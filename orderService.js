const toogler = document.querySelector(".navbar-toggler")
const modelOpen = document.querySelector("#exampleModal")
const closebtn =document.querySelector(".closebtn")
const clickbtn = document.querySelectorAll(".clickbtn")
const qiestions = document.querySelectorAll(".qiestions")

    toogler.addEventListener("click",()=>{
      modelOpen.classList.add("show")
      modelOpen.style.display="block"
    })

    closebtn.addEventListener("click",()=>{
      modelOpen.classList.remove("show")
      modelOpen.style.display="none"
    })
  
    clickbtn.forEach((option)=>{
      option.addEventListener("click",(e)=>{
        clickbtn.forEach((item)=>{
                if(item.innerText === e.target.innerText ){
                    item.classList.add("active")
                    item.nextElementSibling.classList.add("active")
                }else{
                  item.classList.remove("active")
                   item.nextElementSibling.classList.remove("active")
                }
          })
      })
    })

    qiestions.forEach((ques)=>{
      ques.addEventListener("click",(e)=>{
        ques.nextElementSibling.classList.toggle("active")
        ques.lastElementChild.classList.toggle("active")
      })
    })


    /* Scroll to h1 on mobile devices  start */

    document.addEventListener("DOMContentLoaded", function () {
    if (window.innerWidth <= 768) { // Mobile only

        const heading = document.querySelector("h1");

        if (heading) {
            setTimeout(() => {
                heading.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });
            }, 300);
        }
    }
});

/* Scroll to h1 on mobile devices end */
