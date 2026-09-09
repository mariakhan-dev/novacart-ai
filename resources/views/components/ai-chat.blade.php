<div id="aiButton"
    class="fixed bottom-6 right-6 z-50 cursor-pointer">

    <div class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-600 to-indigo-700
                shadow-2xl flex items-center justify-center
                text-3xl text-white hover:scale-110 transition">

        🤖

    </div>

</div>

<div id="aiBox"
     class="hidden fixed bottom-24 right-6 w-96 h-[600px]
            bg-white rounded-3xl shadow-2xl overflow-hidden
            z-50 border border-gray-200">

    <!-- Header -->

    <div class="bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900
                text-white p-5 flex justify-between items-center">

        <div>

            <h2 class="font-bold text-xl">
                NovaCart AI
            </h2>

            <p class="text-sm text-blue-200">
                Your Shopping Assistant
            </p>

        </div>

        <button id="closeAI"
                class="text-2xl hover:text-red-300">

            ✕

        </button>

    </div>

    <!-- Chat -->

    <div id="chatMessages"
         class="h-[430px] overflow-y-auto p-4 bg-gray-50">

        <div class="bg-blue-100 text-gray-800 rounded-2xl p-3 inline-block max-w-[85%]">

            👋 Hello!

            <br><br>

            I'm NovaCart AI.

            Ask me anything about products.

        </div>

    </div>

    <!-- Input -->

    <div class="border-t p-3 flex gap-2">

        <input
            id="userMessage"
            type="text"
            placeholder="Ask about any product..."
            class="flex-1 border rounded-xl px-4 py-3 focus:outline-none">

        <button
            id="sendMessage"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 rounded-xl">

            Send

        </button>

    </div>

</div>

<script>
const aiButton = document.getElementById('aiButton');
const aiBox = document.getElementById('aiBox');
const closeAI = document.getElementById('closeAI');

aiButton.onclick = () => {
    aiBox.classList.remove('hidden');
};

closeAI.onclick = () => {
    aiBox.classList.add('hidden');
};

document.getElementById('sendMessage').onclick = sendMessage;

document.getElementById('userMessage').addEventListener('keypress', function(e){
    if(e.key === 'Enter'){
        sendMessage();
    }
});

async function sendMessage(){

    let input = document.getElementById('userMessage');

    let message = input.value.trim();

    if(message=="") return;

    let chat = document.getElementById('chatMessages');

    chat.innerHTML += `
        <div class="flex justify-end mt-4">
            <div class="bg-blue-600 text-white rounded-2xl px-4 py-3 max-w-[80%]">
                ${message}
            </div>
        </div>
    `;

    input.value="";

    chat.scrollTop = chat.scrollHeight;

    try{

        let response = await fetch("{{ route('ai.chat') }}",{

            method:"POST",

            headers:{
                "Content-Type":"application/json",
                "X-CSRF-TOKEN":"{{ csrf_token() }}"
            },

            body:JSON.stringify({
                message:message
            })

        });

        let data = await response.json();

let html = `
    <div class="flex mt-4">
        <div class="bg-gray-200 rounded-2xl px-4 py-3 max-w-[80%]">
            ${data.reply}
`;

if (data.products && data.products.length > 0) {

    html += `<div class="mt-4 space-y-3">`;

    data.products.forEach(product => {

        html += `
            <a href="${product.url}"
               class="flex items-center gap-3 bg-white rounded-xl p-3 border hover:shadow transition">

                <img src="${product.image}"
                     class="w-16 h-16 object-cover rounded-lg">

                <div>
                    <div class="font-semibold">${product.name}</div>
                    <div class="text-orange-500 font-bold">
                        Rs ${product.price}
                    </div>
                </div>

            </a>
        `;

    });

    html += `</div>`;
}

html += `
        </div>
    </div>
`;

chat.innerHTML += html;

chat.scrollTop = chat.scrollHeight;

    }catch(e){

        chat.innerHTML += `
            <div class="flex mt-4">
                <div class="bg-red-100 text-red-600 rounded-xl px-4 py-3">
                    Unable to contact NovaCart AI.
                </div>
            </div>
        `;

    }

}
</script>