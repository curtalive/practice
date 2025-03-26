document.addEventListener("DOMContentLoaded", function () {
    // --- Слайдер товаров ---
    const slides = document.querySelectorAll(".slide");
    const prevBtn = document.querySelector(".prev");
    const nextBtn = document.querySelector(".next");
    let currentIndex = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.style.display = i === index ? "block" : "none";
        });
    }

    prevBtn.addEventListener("click", function () {
        currentIndex = (currentIndex - 1 + slides.length) % slides.length;
        showSlide(currentIndex);
    });

    nextBtn.addEventListener("click", function () {
        currentIndex = (currentIndex + 1) % slides.length;
        showSlide(currentIndex);
    });

    showSlide(currentIndex); 

    // --- Автоматическое перелистывание слайдов ---
    setInterval(() => {
        currentIndex = (currentIndex + 1) % slides.length;
        showSlide(currentIndex);
    }, 5000);

    // --- Слайдер отзывов ---
    const reviews = document.querySelectorAll(".review");
    let reviewIndex = 0;

    function showReview(index) {
        reviews.forEach((review, i) => {
            review.style.display = i === index ? "block" : "none";
        });
    }

    function nextReview() {
        reviewIndex = (reviewIndex + 1) % reviews.length;
        showReview(reviewIndex);
    }

    showReview(reviewIndex);
    setInterval(nextReview, 4000); 
});
