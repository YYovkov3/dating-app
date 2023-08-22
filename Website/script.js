function checkAge() {
    var ageInput = document.getElementById("age");
    var age = parseInt(ageInput.value);

    if (age > 18) {
        // Продължавате с регистрационния процес
    } else {
        alert("Трябва да сте на възраст над 18 години, за да се регистрирате.");
    }
}
const chatInput = document.querySelector(".chat-input textarea");
const sendChatBtn = document.querySelector(".chat-input span");
const chatbox = document.querySelector(".chatbox")
const chatbotToggler = document.querySelector(".chatbot-toggler");
const chatbotCloseBtn = document.querySelector(".close-btn");

let userMessage;
const API_KEY = "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";

const createChatLi = (message, className) => {
  const chatLi = document.createElement("li");
  chatLi.classList.add("chat", className);
  let chatContent = className === "outgoing" ? `<p></p>` : `<span class="material-symbols-outlinded"><i class="fa-solid fa-robot"></i></span><p></p>`;
  chatLi.innerHTML = chatContent;
  chatLi.querySelector("p").textContent = message;
  return chatLi;
}
const generateRespone = (incomingChatLi) => {
  const API_URL = "https://api.openai.com/v1/chat/completions";
  const messageElement = incomingChatLi.querySelector("p");
  const requestOptions = {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "Authorization": `Bearer ${API_KEY}`
    },
    body: JSON.stringify({
      model: "gpt-3.5-turbo",
      messages: [{role: "user", content: userMessage}]
    })
    
  }

  fetch(API_URL, requestOptions).then(res => res.json()).then(data => {
    messageElement.textContent = data.choices[0].message.content;
  }).catch((error) =>{
    messageElement.classList.add("error");
    messageElement.textContent = "Oops! Something went wrong. Please try again.";
  }).finally(() => chatbox.scrollTo(0, chatbox.scrollHeight));
}

const handleChat = () => {
  userMessage = chatInput.value.trim();
  if(!userMessage) return;
  chatInput.value ="";

  chatbox.appendChild(createChatLi(userMessage, "outgoing"));
  chatbox.scrollTo(0, chatbox.scrollHeight);

  setTimeout (() =>{
    const incomingChatLi = createChatLi(("Thinking...", "Thinking..."))
    chatbox.appendChild(incomingChatLi);
    chatbox.scrollTo(0, chatbox.scrollHeight);
    generateRespone(incomingChatLi);
  },600
  );
}

sendChatBtn.addEventListener("click", handleChat);
chatbotToggler.addEventListener("click", () => document.body.classList.toggle("show-chatbot"));
chatbotCloseBtn.addEventListener("click", () => document.body.classList.toggle("show-chatbot"));