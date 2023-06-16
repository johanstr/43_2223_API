let params = null;
let topic_info = null;
let replies = null;
let topic = [];
let form_create_reply = null;

window.onload = function () {
   params = new Proxy(new URLSearchParams(window.location.search), {
      get: (searchParams, prop) => searchParams.get(prop),
   });

   topic_info = document.querySelector('#topic-info');
   replies = document.querySelector('#replies');
   form_create_reply = document.querySelector('#form-create-reply');
   form_create_reply.addEventListener('submit', submitNewReply);

   CKEDITOR.replace( 'message-body' );

   getTopic();
};

async function submitNewReply(event)
{
   event.preventDefault();

   let formData = new FormData();
   let content = CKEDITOR.instances['message-body'].getData();
   let user_id = document.querySelector('input[name=user_id]').value;

   formData.append('topic_id', params.topic_id);
   formData.append('user_id', user_id);
   formData.append('content', content);
   
   await fetch("http://forum-api-backend.local/reply",
      {
         headers: {
            "Access-Control-Allow-Origin":   "*",
            "Accept":                        "application/json",
            // "Content-Type":                  "multipart/form-data",     DEZE MAG NIET VANWEGE FORMDATA OBJECT
         },
         method: "POST",
         body: formData,
      }
   )
      .then(response => response.json() )
      .then(data => {
         insertNewReply(data.data);
      })
      .catch(error => console.log(error));
}

async function getTopic()
{
   await fetch('http://forum-api-backend.local/topic/' + params.topic_id)
      .then(response => response.json())
      .then(data => {
         topic = data.data;

         showTopic();
         showReplies();
      })
      .catch(error => console.log(error));
}

function insertNewReply(reply)
{
   let reply_block = '';

   reply_block = `
         <div class="collection">
            <div class="collection-item row">
                  <div class="col s2">
                     <span class="reply-username">${reply.username}</span>
                     <span class="reply-timestamp">Geplaatst op:</span>
                     <span class="reply-timestamp">${reply.created_at}</span>
                  </div>
                  <div class="col s10">
                     <p>${reply.content}</p>
                  </div>
            </div>
         </div>
      `;
   
   replies.innerHTML += reply_block;
}

function showTopic()
{
   topic_info.innerHTML = `
   <div class="collection-item row">
      <div class="col s3">
         <div class="avatar collection-link">
            <div class="row">
                  <div class="col s3">
                     <img src="http://www.gravatar.com/avatar/fc7d81525f7040b7e34b073f0218084d?s=50" alt="" class="square">
                  </div>
                  <div class="col s9">
                     <p class="user-name">${topic.username}</p>
                  </div>
            </div>
            <p class="post-timestamp">
                  Laatst aangepast op: ${topic.updated_at ?? topic.created_at}
            </p>
            
         </div>
      </div>
      <div class="col s9">
         <div class="row last-row">
            <div class="col s12">
                  <h6 class="title">${topic.title}</h6>
                  <p>
                     ${topic.content}
                  </p>
            </div>
         </div>
      </div>
   </div>
   `;
}

function showReplies()
{
   let reply_block = '';

   topic.replies.forEach(reply => {
      reply_block = `
         <div class="collection">
            <div class="collection-item row">
                  <div class="col s2">
                     <span class="reply-username">${reply.username}</span>
                     <span class="reply-timestamp">Geplaatst op:</span>
                     <span class="reply-timestamp">${reply.created_at}</span>
                  </div>
                  <div class="col s10">
                     <p>${reply.content}</p>
                  </div>
            </div>
         </div>
      `;

      replies.innerHTML += reply_block;
   });
}