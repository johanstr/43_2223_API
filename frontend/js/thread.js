let params = null;
let show_topics_element = null;
let thread_title = null;
let thread = [];

window.onload = function () {
   params = new Proxy(new URLSearchParams(window.location.search), {
      get: (searchParams, prop) => searchParams.get(prop),
   });

   show_topics_element = document.querySelector('#show-topics');
   thread_title = document.querySelector('#card-title');

   getThread();
};

async function getThread()
{
   await fetch('http://forum-api-backend.local/thread/' + params.thread_id)
      .then(response => response.json())
      .then(data => {
         thread = data.data;

         thread_title.innerHTML = thread.title;
         showTopics();
      })
      .catch(error => console.log(error));
}

function showTopics()
{
   let topic_block = '';

   thread.topics.forEach(topic => {
      topic_block = `
      <!-- BEGIN TOPIC -->
      <a href="topic.html?topic_id=${topic.id}" class="collection-item avatar collection-link">
            <img src="http://www.gravatar.com/avatar/fc7d81525f7040b7e34b073f0218084d?s=50" alt="" class="square">

            <div class="row">
               
               <div class="col s8">
                  <div class="row last-row">
                        <div class="col s12">
                           <span class="title">${topic.title}</span>
                           <p>${topic.content}</p>
                        </div>
                  </div>
                  <div class="row last-row">
                        <div class="col s12 post-timestamp">Gepost door: ${topic.username} op: ${topic.created_at}</div>
                  </div>
               </div>

               <div class="col s2">
                  <h6 class="title center-align">Replies</h6>
                  <p class="center replies">${topic.reply_count}</p>
               </div>

               <div class="col s2">
                  <h6 class="title center-align">Status</h6>
                  <div class="status-wrapper">
                        <span class="status-badge status-open">open</span>
                  </div>
               </div>

            </div>
      </a>
      <!-- EINDE TOPIC -->
      `;

      show_topics_element.innerHTML += topic_block;
   });
}