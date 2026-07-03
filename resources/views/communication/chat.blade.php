@extends('layouts.app')

@section('title', 'Secure Internal Message Channel')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 bg-white">
                <div class="card-header bg-success text-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold">💬 Chat Channel with: {{ $receiver->name }}</h6>
                    <span class="badge bg-light text-dark font-monospace small">Role: {{ strtoupper($receiver->role) }}</span>
                </div>

                <div class="card-body bg-light p-4 overflow-auto" id="chat-box" style="height: 400px;">
                    <div class="text-center text-muted small my-5 font-monospace">Synchronizing encrypted link parameters stream...</div>
                </div>

                <div class="card-footer bg-white border-top p-3">
                    <form id="chat-form" class="input-group">
                        @csrf
                        <input type="text" id="message-text" class="form-control" placeholder="Type your message here..." autocomplete="off" required>
                        <button type="submit" class="btn btn-success fw-bold px-4">Transmit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const chatBox = document.getElementById('chat-box');
    const chatForm = document.getElementById('chat-form');
    const msgInput = document.getElementById('message-text');
    const fetchUrl = "{{ route('chat.fetch', $receiver->id) }}";
    const sendUrl = "{{ route('chat.send', $receiver->id) }}";

    function loadMessages() {
        fetch(fetchUrl)
            .then(res => res.json())
            .then(data => {
                chatBox.innerHTML = '';
                if(data.messages.length === 0) {
                    chatBox.innerHTML = `<div class="text-center text-muted small mt-5">No previous conversation found. Type below to start checking out tools!</div>`;
                    return;
                }
                data.messages.forEach(msg => {
                    const isMe = msg.sender_id === data.current_user;
                    const alignment = isMe ? 'text-end' : 'text-start';
                    const color = isMe ? 'bg-success text-white' : 'bg-white border text-dark';
                    
                    chatBox.innerHTML += `
                        <div class="${alignment} mb-3">
                            <div class="d-inline-block rounded p-3 small shadow-sm ${color}" style="max-width: 75%;">
                                <p class="mb-1 fw-normal">${msg.message}</p>
                            </div>
                        </div>
                    `;
                });
            });
    }

    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const text = msgInput.value;
        if(!text.trim()) return;

        fetch(sendUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify({ message: text })
        }).then(() => {
            msgInput.value = '';
            loadMessages();
            chatBox.scrollTop = chatBox.scrollHeight;
        });
    });

    // Run the live message synchronization loop every 3 seconds
    loadMessages();
    setInterval(loadMessages, 3000);
</script>
@endsection