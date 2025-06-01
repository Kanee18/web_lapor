<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'LaporIn') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
        <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
        <link rel="icon" href="{{ asset ('image/icon.png') }}" sizes="16x16" type="image/png" /> 

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('styles')

        @push('styles')
        <style>
            .typing-indicator span {
                display: inline-block;
                width: 8px;
                height: 8px;
                margin: 0 2px;
                background-color: currentColor; 
                border-radius: 50%;
                animation: typing-bounce 1.4s infinite ease-in-out both;
            }

            .typing-indicator span:nth-child(1) {
                animation-delay: -0.32s;
            }

            .typing-indicator span:nth-child(2) {
                animation-delay: -0.16s;
            }

            @keyframes typing-bounce {
                0%, 80%, 100% {
                    transform: scale(0);
                }
                40% {
                    transform: scale(1.0);
                }
            }
        </style>
        @endpush
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-full mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main>
                {{ $slot }}
            </main>
        </div>

        <div id="chatbot-toggler" class="fixed bottom-6 right-6 z-[9998] p-3 bg-primary hover:bg-primary-dark text-white rounded-full shadow-lg cursor-pointer transition-all duration-200 hover:scale-110 transform scale-100 opacity-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
        </div>

        <div id="chatbot-popup"
     class="hidden fixed bottom-24 right-6 z-[9999] w-80 sm:w-96 h-[70vh] max-h-[500px] bg-white dark:bg-gray-800 rounded-xl shadow-2xl flex flex-col
            transition-all duration-300 ease-in-out transform translate-y-full opacity-0">
            {{-- Header Chatbot --}}
            <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700 bg-primary text-white rounded-t-xl">
                <h3 class="text-lg font-semibold">Chat Bantuan</h3>
                <button id="close-chatbot" class="text-white hover:text-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="chat-messages" class="flex-grow p-4 space-y-3 overflow-y-auto bg-gray-50 dark:bg-gray-700/80">
                <div class="flex">
                    <div class="bg-primary-light dark:bg-primary-dark text-gray-900 dark:text-gray-100 p-3 rounded-lg rounded-bl-none max-w-[80%] shadow">
                        <p class="text-sm">Halo! Ada yang bisa saya bantu terkait pelaporan kerusakan?</p>
                    </div>
                </div>
            </div>
            <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-b-xl">
                <form id="chatbot-form" class="flex items-center gap-2">
                    <input type="text" id="chat-input" placeholder="Ketik pesan Anda..." autocomplete="off"
                           class="flex-grow block w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:bg-gray-700 dark:text-gray-200 text-sm py-2.5">
                    <button type="submit" class="p-2.5 bg-primary hover:bg-primary-dark text-white rounded-lg shadow-md transition-colors duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 16.571V11a1 1 0 112 0v5.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

        @stack('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatbotToggler = document.getElementById('chatbot-toggler');
        const chatbotPopup = document.getElementById('chatbot-popup');
        const closeChatbotButton = document.getElementById('close-chatbot');
        const chatMessages = document.getElementById('chat-messages');
        const chatbotForm = document.getElementById('chatbot-form');
        const chatInput = document.getElementById('chat-input');
    
        let isChatbotOpen = false;
        let conversationHistory = [];
        let typingIndicatorElement = null;
    
        function openChatbot() { 
            chatbotPopup.classList.remove('hidden');
            requestAnimationFrame(() => {
                chatbotPopup.classList.remove('translate-y-full', 'opacity-0');
                chatbotPopup.classList.add('translate-y-0', 'opacity-100');
            });
            isChatbotOpen = true;
            chatbotToggler.classList.remove('scale-100', 'opacity-100');
            chatbotToggler.classList.add('scale-0', 'opacity-0');
            setTimeout(() => { chatbotToggler.classList.add('hidden'); }, 300);
            chatInput.focus();
        }
    
        function closeChatbot() { 
            chatbotPopup.classList.add('translate-y-full', 'opacity-0');
            chatbotPopup.classList.remove('translate-y-0', 'opacity-100');
            chatbotToggler.classList.remove('hidden');
            requestAnimationFrame(() => {
                    chatbotToggler.classList.remove('scale-0', 'opacity-0');
                    chatbotToggler.classList.add('scale-100', 'opacity-100');
            });
            setTimeout(() => {
                chatbotPopup.classList.add('hidden');
            }, 300);
            isChatbotOpen = false;
        }
    
        function showTypingIndicator() { 
            if (!typingIndicatorElement) {
                const indicatorHtml = `<div class="typing-indicator"><span></span><span></span><span></span></div>`;
                typingIndicatorElement = addMessage(indicatorHtml, 'bot', true, false); // false untuk streaming
                typingIndicatorElement.id = 'typing-indicator-message';
            }
        }
    
        function hideTypingIndicator() { 
            const indicator = document.getElementById('typing-indicator-message');
            if (indicator) {
                indicator.remove();
                typingIndicatorElement = null;
            }
        }

        function addMessage(messageContent, sender = 'bot', isHtml = false, stream = false, wordsPerChunk = 2, interval = 100) {
            const messageDiv = document.createElement('div');
            messageDiv.classList.add('flex', 'mb-2', 'message-item');
            if (sender === 'user') {
                messageDiv.classList.add('justify-end');
            }
    
            const bubbleDiv = document.createElement('div');
            bubbleDiv.classList.add('p-3', 'rounded-lg', 'max-w-[85%]', 'text-sm', 'shadow');
            if (sender === 'bot') {
                bubbleDiv.classList.add('bg-primary-light', 'dark:bg-primary-dark', 'text-gray-900', 'dark:text-gray-100', 'rounded-bl-none');
            } else {
                bubbleDiv.classList.add('bg-gray-200', 'dark:bg-slate-600', 'text-gray-800', 'dark:text-gray-100', 'rounded-br-none');
            }
    
            const textContainer = document.createElement('p');
            bubbleDiv.appendChild(textContainer);
            messageDiv.appendChild(bubbleDiv);
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight; 
    
            if (sender === 'bot' && stream && typeof messageContent === 'string') {
                const words = messageContent.split(/(\s+)/); 
                let currentChunk = [];
                let i = 0;
    
                function typeWords() {
                    if (i < words.length) {
                        currentChunk.push(words[i]); 
                        if (words[i].trim() !== '') { 
                            let wordCountInChunk = currentChunk.filter(w => w.trim() !== '').length;
                            if (wordCountInChunk >= wordsPerChunk || i === words.length - 1) {
                                textContainer.innerHTML += currentChunk.join(''); 
                                currentChunk = [];
                            }
                        } else {
                            if (currentChunk.length > 1) { 
                                 textContainer.innerHTML += currentChunk.join('');
                                 currentChunk = [];
                            }
                            textContainer.innerHTML += words[i]; 
                        }
    
                        chatMessages.scrollTop = chatMessages.scrollHeight; 
                        i++;
                        setTimeout(typeWords, interval);
                    } else {
                    }
                }
                typeWords(); // Mulai animasi ketik
            } else if (isHtml) {
                textContainer.innerHTML = messageContent; 
            } else {
                textContainer.textContent = messageContent; 
            }
            return messageDiv;
        }
    
    
        if (chatbotToggler && chatbotPopup && closeChatbotButton) {
            chatbotToggler.addEventListener('click', function() {
                isChatbotOpen ? closeChatbot() : openChatbot();
            });
            closeChatbotButton.addEventListener('click', closeChatbot);
        }
    
        if (chatbotForm && chatInput) {
            chatbotForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                const userMessage = chatInput.value.trim();
                if (userMessage === '') return;
    
                addMessage(userMessage, 'user', false, false); 
                conversationHistory.push({ sender: 'user', message: userMessage });
    
                chatInput.value = '';
                chatInput.disabled = true;
                showTypingIndicator();
    
                try {
                    const response = await fetch("{{ route('chatbot.ask') }}", {
                        method: 'POST',
                        headers: { 
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            message: userMessage,
                            history: conversationHistory.slice(-10)
                        })
                    });
    
                    hideTypingIndicator();
    
                    if (!response.ok) {
                        const errorData = await response.json().catch(() => ({ reply: `Error ${response.status}: ${response.statusText}` }));
                        throw new Error(errorData.reply || `Error HTTP: ${response.status}`);
                    }
    
                    const data = await response.json();
                    addMessage(data.reply, 'bot', false, true, 2, 70); 
                    conversationHistory.push({ sender: 'bot', message: data.reply });
    
                } catch (error) {
                    console.error('Error mengirim/menerima pesan chatbot:', error);
                    hideTypingIndicator();
                    addMessage(`Maaf, terjadi masalah: ${error.message || 'Tidak bisa terhubung ke server.'}`, 'bot', true, false); 
                } finally {
                    chatInput.disabled = false;
                    chatInput.focus();
                }
            });
        } else {
            console.warn("Form chatbot atau input tidak ditemukan.");
        }
    });
    </script>