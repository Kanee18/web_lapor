<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    private function formatConversationHistoryForGemini(array $frontendHistory): array
    {
        $geminiHistory = [];
        foreach ($frontendHistory as $turn) {
            if (isset($turn['sender']) && isset($turn['message'])) {
                $role = ($turn['sender'] === 'user') ? 'user' : 'model'; 
                $geminiHistory[] = ['role' => $role, 'parts' => [['text' => $turn['message']]]];
            }
        }
        return $geminiHistory;
    }

    public function ask(Request $request)
    {
        $validatedData = $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'nullable|array', 
        ]);

        $userMessage = $validatedData['message'];
        $conversationHistoryFromFrontend = $validatedData['history'] ?? [];

        $apiKey = config('services.gemini.key');
        $model = config('services.gemini.model', 'gemini-1.5-flash-latest');
        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

        if (!$apiKey) {
            Log::error('Gemini API Key tidak ditemukan.');
            return response()->json(['reply' => 'Maaf, layanan chatbot sedang mengalami kendala teknis (API Key).'], 500);
        }

        $systemInstruction = "Anda adalah LaporinBot, asisten AI untuk website LaporIn di Bali. ".
                             "Tugas Anda adalah membantu pengguna terkait pelaporan kerusakan infrastruktur publik seperti jalan rusak, lampu jalan mati, saluran air tersumbat, dan fasilitas umum lainnya di wilayah Bali. ".
                             "Jawablah pertanyaan dengan ramah, sopan, jelas, dan informatif dalam Bahasa Indonesia. ".
                             "Fokus hanya pada topik yang berkaitan dengan pelaporan kerusakan di Bali. ".
                             "Jika pertanyaan di luar topik tersebut, tolak dengan sopan dan arahkan kembali ke topik utama. ".
                             "Jika Anda tidak tahu jawabannya, katakan terus terang dan sarankan pengguna untuk menghubungi kontak resmi (jika ada informasi kontak) atau mencoba bertanya dengan cara lain. ".
                             "Anda bisa memberikan informasi tentang: cara membuat laporan baru, jenis kerusakan yang bisa dilaporkan, cara melacak status laporan (secara umum), dan memberikan panduan umum. ".
                             "Hindari memberikan opini pribadi atau informasi yang tidak relevan.";

        $formattedHistory = $this->formatConversationHistoryForGemini($conversationHistoryFromFrontend);

        // Bangun 'contents' untuk Gemini API dengan instruksi sistem, histori, dan pesan pengguna baru
        $contents = [
            // Instruksi sistem sebagai pesan pertama dari 'user' jika model mendukung interpretasi ini sebagai konteks global
            // Atau sebagai bagian dari pesan 'model' pertama jika itu cara yang lebih baik (perlu eksperimen/cek dok)
            // Untuk Gemini, seringkali lebih baik instruksi sistem menjadi bagian dari pesan 'user' awal, atau
            // jika model mendukungnya, sebagai pesan 'system' terpisah (jarang untuk Gemini API langsung via REST)
            // Mari kita coba gabungkan dengan pesan user pertama jika histori kosong, atau sebagai pesan terpisah jika histori ada.

            // Jika tidak ada histori, gabungkan instruksi sistem dengan pesan user pertama
            // Jika ada histori, instruksi sistem bisa menjadi giliran 'user' pertama, lalu histori, lalu pesan user terakhir
        ];

        if (empty($formattedHistory)) {
            $contents[] = ['role' => 'user', 'parts' => [['text' => $systemInstruction . "\n\nPertanyaan Pengguna: " . $userMessage]]];
        } else {
            $contents[] = ['role' => 'user', 'parts' => [['text' => $systemInstruction]]]; 
            $contents = array_merge($contents, $formattedHistory); 
            $contents[] = ['role' => 'user', 'parts' => [['text' => $userMessage]]]; 
        }


        $payload = [
            'contents' => $contents,
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 300,
            ],
        ];

        Log::info('Mengirim permintaan ke Gemini API dengan histori:', ['url' => $apiUrl, 'payload' => $payload]);

        try {
            $response = Http::timeout(45)->post($apiUrl, $payload);

            if ($response->successful()) {
                $responseData = $response->json();
                Log::info('Respon sukses dari Gemini API (dengan histori):', ['data' => $responseData]);

                $botReply = data_get($responseData, 'candidates.0.content.parts.0.text');

                if ($botReply) {
                    return response()->json(['reply' => $botReply]);
                } else {
                    $blockReason = data_get($responseData, 'promptFeedback.blockReason');
                    if ($blockReason) {
                         Log::warning('Permintaan (dengan histori) diblokir oleh Gemini:', ['reason' => $blockReason, 'response' => $responseData]);
                         return response()->json(['reply' => 'Maaf, permintaan Anda tidak dapat diproses saat ini karena alasan keamanan. (' . $blockReason . ')'], 400);
                    }
                    Log::error('Respon Gemini (dengan histori) tidak mengandung teks balasan yang diharapkan.', ['response_data' => $responseData]);
                    return response()->json(['reply' => 'Maaf, saya tidak bisa memberikan respons saat ini (format tidak sesuai).'], 500);
                }
            } else {
                Log::error('Error dari Gemini API (dengan histori):', ['status' => $response->status(), 'body' => $response->body()]);
                return response()->json(['reply' => 'Maaf, terjadi kesalahan saat menghubungi layanan AI.'], $response->status());
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Koneksi ke Gemini API (dengan histori) gagal:', ['error' => $e->getMessage()]);
            return response()->json(['reply' => 'Tidak dapat terhubung ke layanan AI. Periksa koneksi Anda.'], 503);
        } catch (\Exception $e) {
            Log::error('Error tidak terduga saat proses chatbot (dengan histori):', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['reply' => 'Maaf, terjadi kesalahan sistem pada chatbot.'], 500);
        }
    }
}