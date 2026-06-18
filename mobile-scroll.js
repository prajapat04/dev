window.addEventListener("load", () => {

    if (window.innerWidth > 768) return;

    setTimeout(() => {

        const heading = document.querySelector("h1");

        if (!heading) return;

        window.scrollTo({
            top: heading.getBoundingClientRect().top + window.pageYOffset - 20,
            behavior: "smooth"
        });

    }, 1500);

});