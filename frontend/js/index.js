let show_threads_element = null;
let threads = [];

window.onload = function () {
   show_threads_element = document.querySelector('#show-threads');

   getThreads();
}

async function getThreads()
{
   await fetch('http://forum-api-backend.local')
      .then(response => response.json())
      .then(data => {
         threads = data.data;

         showThreads();
      })
      .catch(error => console.log(error));
}

function showThreads()
{
   let thread_block = '';

   threads.forEach(thread => {
      thread_block = `
      <!-- BEGIN VAN EEN THREAD -->
      <!-- LET OP: de link gaat hier nog naar thread.html -->
      <a href="thread.html?thread_id=${thread.id}" class="collection-item avatar collection-link">
         <img src="img/icon-php.png" alt="" class="circle">
         <div class="row">
            <div class="col s9">
               <div class="row last-row">
               <div class="col s12">
                  <span class="title">${thread.title}</span>
                  <p>${thread.description}</p>
               </div>
               </div>
               <div class="row last-row">
               <div class="col s12 post-timestamp">Moderator: ${thread.username}</div>
               </div>
            </div>
            <div class="col s3">
               <h6 class="title center-align">Statistieken</h6>
               <p class="center-align">${thread.topic_count} topics</p>
            </div>
         </div>
      </a>
      <!-- EINDE VAN EEN THREAD -->
      `;

      show_threads_element.innerHTML += thread_block;
   });
}