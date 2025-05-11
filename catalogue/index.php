<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mitch Pastries Catalogue</title>
    <link rel="stylesheet" href="style/navigation-bar.css" />
    <link rel="stylesheet" href="style/background-section.css" />
    <link rel="stylesheet" href="style/welcome-section.css" />
    <link rel="stylesheet" href="style/categories.css" />
    <link rel="stylesheet" href="style/special-offer-section.css" />
    <link rel="stylesheet" href="style/featured-products-section.css" />
    <link rel="stylesheet" href="style/popular-items-section.css" />
    <link rel="stylesheet" href="style/all-items-sections.css" />
    <link rel="stylesheet" href="style/pop-up-modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
      * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
      }

      body {
        font-family: "Poppins", sans-serif;
        background-color: whitesmoke;
        width: 100vw;
        min-height: 100vh;
        margin: 0;
      }

      .content {
        width: 100%;
      }
    </style>
  </head>
  <body>
    <div class="content">
      <section class="navigation-bar">
        <div class="top-navbar">
          <div class="nav-section">
            <p class="section-title">MAIN</p>
            <a href="../loading/index.html?target=../homepage/index.html">Home</a>
            <a href="../catalogue/index.html" class="active">Catalogue</a>
            <a href="../Checkout page/index.php">Cart</a>
          </div>

          <div class="nav-section">
            <p class="section-title">ADMIN PANEL</p>
            <a href="../dashboard/index.html">Dashboard</a>
            <a href="../menu/menu.html"> Menu List </a>
            <a href="../SeeCustomerOrders/index.html">Orders</a>
          </div>
        </div>
      </section>

      <section class="background-section"></section>

      <section class="welcome-section">
        <div class="welcome-text">
          <h1>Welcome to Mitch Pastries! 🍰</h1>
          <p>
            Your one-stop shop for heavenly baked treats and irresistible
            desserts.
          </p>
          <div class="button-wrapper">
            <button class="shop-now-btn" onclick="scrollToSectionMenu()">Browse Menu</button>
          </div>
        </div>
      </section>

      <section class="categories1">
        <p  onclick="scrollToSectionDonut()">Donuts</p>
        <p  onclick="scrollToSectionCakes()">Cakes</p>
        <p  onclick="scrollToSectionCookies()">Cookies</p>
        <p  onclick="scrollToSectionMuffins()">Muffins</p>
        <p  onclick="scrollToSectionBrownies()">Brownies</p>
        <p  onclick="scrollToSectionMacarons()">Macarons</p>
        <p  onclick="scrollToSectionCroissant()">Croissants</p>
      </section>

      <section class="special-offer-section">
        <div class="offer-badge"><i class="fa-solid fa-tag"></i> Special Offer</div>
        <div class="special-offer-image"></div>
        <div class="special-offer-info">
          <h3>Strawberry Surprise</h3>
          <p>Limited-time sweet with real strawberries and cream.</p>
          <div class="price-action">
            <span class="product-price">₱1.99</span>
            <button class="add-btn">
              <i class="fa-solid fa-shopping-cart"></i>
              <span>Add to Cart</span>
            </button>
          </div>
        </div>
      </section>

      <section class="featured-products">
        <h2 class="glow-heading">FEATURED PRODUCTS</h2>
        <div class="featured-products-boxes">
      
          <div class="featured-products-card">
            <img src="../images/chocolate-cake.jpg" alt="Chocolate Cake" />
            <div class="label-badge">Best Seller</div>
            <div class="product-info">
              <div>
                <h3>Chocolate Cake</h3>
                <p>Rich and moist chocolate layers.</p>
              </div>
              <div class="product-bottom">
                <p class="price">₱9.99</p>
                <button class="add-to-cart">
                  <i class="fas fa-cart-plus"></i> Add to Cart
                </button>
              </div>
            </div>
          </div>
      
          <div class="featured-products-card">
            <img src="../images/pie.jpg" alt="Fruit Pie" />
            <div class="product-info">
              <div>
                <h3>Fruit Pie</h3>
                <p>Sweet seasonal fruits in a flaky crust.</p>
              </div>
              <div class="product-bottom">
                <p class="price">₱6.99</p>
                <button class="add-to-cart">
                  <i class="fas fa-cart-plus"></i> Add to Cart
                </button>
              </div>
            </div>
          </div>
      
          <div class="featured-products-card">
            <img src="../images/chocolate-donut.jpg" alt="Chocolate Donut" />
            <div class="product-info">
              <div>
                <h3>Chocolate Donut</h3>
                <p>Soft and fluffy with chocolate glaze.</p>
              </div>
              <div class="product-bottom">
                <p class="price">₱2.49</p>
                <button class="add-to-cart">
                  <i class="fas fa-cart-plus"></i> Add to Cart
                </button>
              </div>
            </div>
          </div>
      
          <div class="featured-products-card">
            <img src="../images/muffin.jpg" alt="Blueberry Muffin" />
            <div class="product-info">
              <div>
                <h3>Blueberry Muffin</h3>
                <p>Fresh blueberries and buttery flavor.</p>
              </div>
              <div class="product-bottom">
                <p class="price">₱3.29</p>
                <button class="add-to-cart">
                  <i class="fas fa-cart-plus"></i> Add to Cart
                </button>
              </div>
            </div>
          </div>
      
          <div class="featured-products-card">
            <img src="../images/macaron.jpg" alt="Macaron" />
            <div class="product-info">
              <div>
                <h3>Macaron</h3>
                <p>Colorful, crisp, and chewy French treat.</p>
              </div>
              <div class="product-bottom">
                <p class="price">₱1.99</p>
                <button class="add-to-cart">
                  <i class="fas fa-cart-plus"></i> Add to Cart
                </button>
              </div>
            </div>
          </div>
      
          <div class="featured-products-card">
            <img src="../images/chocolate-brownies.jpg" alt="Chocolate Brownie" />
            <div class="product-info">
              <div>
                <h3>Chocolate Brownie</h3>
                <p>Fudgy and rich chocolate flavor.</p>
              </div>
              <div class="product-bottom">
                <p class="price">₱4.49</p>
                <button class="add-to-cart">
                  <i class="fas fa-cart-plus"></i> Add to Cart
                </button>
              </div>
            </div>
          </div>
      
        </div>
      </section>
  
      <section class="popular-items-section">
        <h1 class="popular-items">Popular Items</h1>
        <div class="carousel-wrapper" id="carousel-wrapper">
          <div class="popular-boxes" id="carousel-track">
            <!-- Card 1 -->
            <div class="popular-card">
              <img src="../images/chocolate-cake.jpg" alt="Chocolate Cake" />
              <div class="name-des">
                <p class="item-name">Chocolate Cake</p>
                <a class="popu-item-def">Rich and moist chocolate layers.</a>
              </div>
              <div class="popular-price-bttn">
                <span class="popular-item-price">₱5.99</span>
                <button class="add-to-cart">
                  <i class="fas fa-cart-plus"></i> Add to Cart
                </button>
              </div>
            </div>
      
            <!-- Card 2 -->
            <div class="popular-card">
              <img src="../images/chocolate-marble.jpg" alt="Choco Marble" />
              <div class="name-des">
                <p class="item-name">Choco Marble</p>
                <a class="popu-item-def">Soft and fluffy chocolate glaze.</a>
              </div>
              <div class="popular-price-bttn">
                <span class="popular-item-price">₱5.99</span>
                <button class="add-to-cart">
                  <i class="fas fa-cart-plus"></i> Add to Cart
                </button>
              </div>
            </div>
      
            <!-- Card 3 -->
            <div class="popular-card">
              <img src="../images/strawberry-tart.jpg" alt="Strawberry Tart" />
              <div class="name-des">
                <p class="item-name">Strawberry Tart</p>
                <a class="popu-item-def">Crisp crust with fresh strawberries.</a>
              </div>
              <div class="popular-price-bttn">
                <span class="popular-item-price">₱5.99</span>
                <button class="add-to-cart">
                  <i class="fas fa-cart-plus"></i> Add to Cart
                </button>
              </div>
            </div>
      
            <!-- Card 4 -->
            <div class="popular-card">
              <img src="../images/blueberry-muffin.jpg" alt="Blueberry Muffin" />
              <div class="name-des">
                <p class="item-name">Blueberry Muffin</p>
                <a class="popu-item-def">Bursting with fresh blueberries.</a>
              </div>
              <div class="popular-price-bttn">
                <span class="popular-item-price">₱4.99</span>
                <button class="add-to-cart">
                  <i class="fas fa-cart-plus"></i> Add to Cart
                </button>
              </div>
            </div>
      
            <!-- Card 5 -->
            <div class="popular-card">
              <img src="../images/caramel-brownies.jpg" alt="Caramel Brownie" />
              <div class="name-des">
                <p class="item-name">Caramel Brownie</p>
                <a class="popu-item-def">Fudgy base with a caramel swirl.</a>
              </div>
              <div class="popular-price-bttn">
                <span class="popular-item-price">₱3.99</span>
                <button class="add-to-cart">
                  <i class="fas fa-cart-plus"></i> Add to Cart
                </button>
              </div>
            </div>
      
            <!-- Card 6 -->
            <div class="popular-card">
              <img src="../images/rainbow-macarons.jpg" alt="Rainbow Macarons" />
              <div class="name-des">
                <p class="item-name">Rainbow Macarons</p>
                <a class="popu-item-def">Assorted flavors and vibrant colors.</a>
              </div>
              <div class="popular-price-bttn">
                <span class="popular-item-price">₱6.49</span>
                                <button class="add-to-cart">
                  <i class="fas fa-cart-plus"></i> Add to Cart
                </button>
              </div>
            </div>
          </div>
        </div>
      </section>

    <section id="menu" class="all-items-section">
        <!-- CROISSANTS -->
    <section id="croissant-section" class="section">
      <h1 class="food-title">CROISSANTS</h1>
      <div class="Food">
        <div class="card">
          <img class="img" src="../images/croissant.jpg" alt="Croissant" />
          <div class="name-des">
            <p class="item-name">Choco Marble</p>
            <p class="item-def">Flaky croissant filled with rich chocolate layers.</p>
            <div class="all-price-bttn">
              <span class="item-price">₱5.99</span>
              <button class="all-add-bttn"><i class="fas fa-cart-plus"></i></button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CAKES -->
    <section id="cake-section" class="section">
      <h1 class="food-title">CAKES</h1>
      <div class="Food">
        <div class="card">
          <img class="img" src="../images/chocolate-cake.jpg" alt="Cake" />
          <div class="name-des">
            <p class="item-name">Choco Marble</p>
            <p class="item-def">Delicious chocolate marble cake with creamy texture.</p>
            <div class="all-price-bttn">
              <span class="item-price">₱5.99</span>
              <button class="all-add-bttn"><i class="fas fa-cart-plus"></i></button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- COOKIES -->
    <section id="cookie-section" class="section">
      <h1 class="food-title">COOKIES</h1>
      <div class="Food">
        <div class="card">
          <img class="img" src="../images/cookies.jpg" alt="Cookies" />
          <div class="name-des">
            <p class="item-name">Choco Marble</p>
            <p class="item-def">Crunchy outside, chewy inside with chocolate swirls.</p>
            <div class="all-price-bttn">
              <span class="item-price">₱5.99</span>
              <button class="all-add-bttn"><i class="fas fa-cart-plus"></i></button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- MUFFINS -->
    <section id="muffin-section" class="section">
      <h1 class="food-title">MUFFINS</h1>
      <div class="Food">
        <div class="card">
          <img class="img" src="../images/muffin.jpg" alt="Muffin" />
          <div class="name-des">
            <p class="item-name">Choco Marble</p>
            <p class="item-def">Moist chocolate muffin perfect with coffee.</p>
            <div class="all-price-bttn">
              <span class="item-price">₱5.99</span>
              <button class="all-add-bttn"><i class="fas fa-cart-plus"></i></button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- BROWNIES -->
    <section id="brownie-section" class="section">
      <h1 class="food-title">BROWNIES</h1>
      <div class="Food">
        <div class="card">
          <img class="img" src="../images/chocolate-brownies.jpg" alt="Brownie" />
          <div class="name-des">
            <p class="item-name">Choco Marble</p>
            <p class="item-def">Rich and fudgy chocolate brownie.</p>
            <div class="all-price-bttn">
              <span class="item-price">₱5.99</span>
              <button class="all-add-bttn"><i class="fas fa-cart-plus"></i></button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- MACARONS -->
    <section id="macaron-section" class="section">
      <h1 class="food-title">MACARONS</h1>
      <div class="Food">
        <div class="card">
          <img class="img" src="../images/macaron.jpg" alt="Macaron" />
          <div class="name-des">
            <p class="item-name">Choco Marble</p>
            <p class="item-def">Delicate French macarons with a chocolaty twist.</p>
            <div class="all-price-bttn">
              <span class="item-price">₱5.99</span>
              <button class="all-add-bttn"><i class="fas fa-cart-plus"></i></button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- DONUTS -->
    <section id="donut-section" class="section">
      <h1 class="food-title">DONUTS</h1>
      <div class="Food">
        <div class="card">
          <img class="img" src="../images/chocolate-donut.jpg" alt="Donut" />
          <div class="name-des">
            <p class="item-name">Choco Marble</p>
            <p class="item-def">Classic donut glazed and filled with chocolate.</p>
            <div class="all-price-bttn">
              <span class="item-price">₱5.99</span>
              <button class="all-add-bttn"><i class="fas fa-cart-plus"></i></button>
            </div>
          </div>
        </div>
      </div>
    </section>

    </div>
    <footer class="footer">
      <div class="footer-content">
        <p>&copy; 2025 Mitch's Pastries. All rights reserved.</p>
        <p>Designed by Fernandez, Tatel, and Tenorio</p>
      </div>
    </footer> 

    <script>
      document.addEventListener("DOMContentLoaded", () => {
        const observer = new IntersectionObserver((entries) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              entry.target.classList.add("fade-in-section");
            }
          });
        }, { threshold: 0.1 });
    
        document.querySelectorAll(".section").forEach(el => {
          observer.observe(el);
        });
      });
    </script>
    
    <script>
      window.addEventListener("DOMContentLoaded", () => {
        const container = document.querySelector(".popular-boxes");
        if (container) {
          container.scrollLeft =
            (container.scrollWidth - container.clientWidth) / 2;
        }
      });

      document.addEventListener("DOMContentLoaded", () => {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("fade-in-trigger");
        observer.unobserve(entry.target); // Only animate once
      }
    });
  }, { threshold: 0.1 });

  // Observe all section ad the popular-items-section
  document.querySelectorAll(".section, .popular-items-section").forEach(el => {
    observer.observe(el);
  });
});
    </script>

     <script>
      window.addEventListener("DOMContentLoaded", () => {
        const container = document.querySelector(".Food");
        if (container) {
          container.scrollLeft =
            (container.scrollWidth - container.clientWidth) / 2;
        }
      });
    </script>


<script>
  function showModal(item) {
    const existingModal = document.getElementById('universalItemModal');
    if (existingModal) existingModal.remove();

    const modal = document.createElement('div');
    modal.className = 'modal';
    modal.id = 'universalItemModal';
    modal.innerHTML = `
      <div class="modal-content">
        <span class="close">&times;</span>
        <img src="${item.imgSrc}" class="modal-img">
        <h2 class="modal-title">${item.name}</h2>
        <p class="modal-description">${item.description}</p>
        <p class="modal-price">${item.price}</p>
        <div class="modal-actions">
          <div class="quantity-control">
            <button class="quantity-btn minus">-</button>
            <span class="quantity">1</span>
            <button class="quantity-btn plus">+</button>
          </div>
          <button class="add-to-cart-btn">Add to Cart</button>
        </div>
      </div>
    `;

    document.body.appendChild(modal);

    modal.querySelector('.close').addEventListener('click', () => modal.remove());
    modal.addEventListener('click', (e) => {
      if (e.target === modal) modal.remove();
    });

    const minusBtn = modal.querySelector('.minus');
    const plusBtn = modal.querySelector('.plus');
    const quantitySpan = modal.querySelector('.quantity');

    minusBtn.addEventListener('click', () => {
      let quantity = parseInt(quantitySpan.textContent);
      if (quantity > 1) quantitySpan.textContent = quantity - 1;
    });

    plusBtn.addEventListener('click', () => {
      let quantity = parseInt(quantitySpan.textContent);
      quantitySpan.textContent = quantity + 1;
    });

    modal.querySelector('.add-to-cart-btn').addEventListener('click', () => {
      const quantity = parseInt(quantitySpan.textContent);
      addToCart(item, quantity);
      modal.remove();
    });

    modal.style.display = 'block';
  }

  function addToCart(item, quantity = 1) {
    // Extract numeric price (remove currency symbol)
    const price = parseFloat(item.price.replace(/[^0-9.]/g, ''));
    
    // Generate a simple product ID if not provided (you might want to use actual IDs from your database)
    const productId = item.id || item.name.toLowerCase().replace(/\s+/g, '-');
    
    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('product_name', item.name);
    formData.append('price', price);
    formData.append('quantity', quantity);

    fetch('add_to_cart.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.text())
    .then(message => {
      alert(message); // Or show a nicer notification
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Error adding to cart');
    });
  }

  document.addEventListener('DOMContentLoaded', () => {
    // Handle clicks on all product cards
    document.body.addEventListener('click', (e) => {
      let card = e.target.closest('.card, .popular-card, .featured-products-card');
      if (!card) return;

      // Extract values depending on card type
      let imgSrc, name, description, price;

      if (card.classList.contains('popular-card')) {
        imgSrc = card.querySelector('img')?.src;
        name = card.querySelector('.item-name')?.textContent;
        description = card.querySelector('.popu-item-def')?.textContent;
        price = card.querySelector('.popular-item-price')?.textContent;
      } else if (card.classList.contains('featured-products-card')) {
        imgSrc = card.querySelector('img')?.src;
        name = card.querySelector('h3')?.textContent;
        description = card.querySelector('p:not(.price)')?.textContent;
        price = card.querySelector('.price')?.textContent;
      } else if (card.classList.contains('card')) {
        imgSrc = card.querySelector('img')?.src;
        name = card.querySelector('.item-name')?.textContent;
        description = card.querySelector('.item-def')?.textContent;
        price = card.querySelector('.item-price')?.textContent;
      }

      if (imgSrc && name && description && price) {
        showModal({ imgSrc, name, description, price });
      }
    });

    // Handle direct "Add to Cart" button clicks (without modal)
    document.body.addEventListener('click', (e) => {
      const addButton = e.target.closest('.add-to-cart, .all-add-bttn, .add-btn');
      if (!addButton) return;

      e.preventDefault();
      e.stopPropagation();

      let card = addButton.closest('.card, .popular-card, .featured-products-card, .special-offer-info');
      if (!card) return;

      let name, price;
      
      if (card.classList.contains('popular-card')) {
        name = card.querySelector('.item-name')?.textContent;
        price = card.querySelector('.popular-item-price')?.textContent;
      } else if (card.classList.contains('featured-products-card')) {
        name = card.querySelector('h3')?.textContent;
        price = card.querySelector('.price')?.textContent;
      } else if (card.classList.contains('card')) {
        name = card.querySelector('.item-name')?.textContent;
        price = card.querySelector('.item-price')?.textContent;
      } else if (card.classList.contains('special-offer-info')) {
        name = card.querySelector('h3')?.textContent;
        price = card.querySelector('.product-price')?.textContent;
      }

      if (name && price) {
        addToCart({ 
          name, 
          price,
          description: '' // You might want to add description here if needed
        });
      }
    });
  });
</script>



<script>
  function scrollToSectionMenu() {
    const section = document.getElementById('croissant-section');
    section.scrollIntoView({
      behavior: 'smooth',
      block: 'center'
    });
    
  }
  function scrollToSectionCroissant() {
    const section = document.getElementById('croissant-section');
    section.scrollIntoView({
      behavior: 'smooth',
      block: 'center'
    });
    
  }
  function scrollToSectionDonut() {
    const section = document.getElementById('donut-section');
    section.scrollIntoView({
      behavior: 'smooth',
      block: 'center'
    });
    
  }
  function scrollToSectionCakes() {
    const section = document.getElementById('cake-section');
    section.scrollIntoView({
      behavior: 'smooth',
      block: 'center'
    });
    
  }
  function scrollToSectionCookies() {
    const section = document.getElementById('cookie-section');
    section.scrollIntoView({
      behavior: 'smooth',
      block: 'center'
    });
    
  }
  function scrollToSectionMuffins() {
    const section = document.getElementById('muffin-section');
    section.scrollIntoView({
      behavior: 'smooth',
      block: 'center'
    });
    
  }
  function scrollToSectionBrownies() {
    const section = document.getElementById('brownie-section');
    section.scrollIntoView({
      behavior: 'smooth',
      block: 'center'
    });
    
  }
  function scrollToSectionMacarons() {
    const section = document.getElementById('macaron-section');
    section.scrollIntoView({
      behavior: 'smooth',
      block: 'center'
    });
    
  }
  
</script>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const carouselTrack = document.getElementById('carousel-track');
    const carouselWrapper = document.getElementById('carousel-wrapper');

    // Clone cards for seamless looping
    const cards = Array.from(carouselTrack.children);
    cards.forEach(card => {
      const clone = card.cloneNode(true);
      carouselTrack.appendChild(clone);
    });

    let scrollSpeed = 0.5; // Smooth scroll speed
    let scrollPosition = 0;
    let animationFrame;

    function autoScroll() {
  scrollPosition += scrollSpeed;
  carouselWrapper.scrollLeft = scrollPosition;

  // When halfway, reset instantly
  if (scrollPosition >= carouselTrack.scrollWidth / 2) {
    scrollPosition = 0;
    carouselWrapper.scrollLeft = 0;
  }

  animationFrame = requestAnimationFrame(autoScroll);
}

    function startScroll() {
      animationFrame = requestAnimationFrame(autoScroll);
    }

    function stopScroll() {
      cancelAnimationFrame(animationFrame);
    }

    startScroll();

    carouselWrapper.addEventListener('mouseenter', stopScroll);
    carouselWrapper.addEventListener('mouseleave', startScroll);
  });
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    fetch('fetch-menu.php')
        .then(response => response.json())
        .then(data => {
            const categoryToSectionId = {
                croissants: "croissant-section",
                cakes: "cake-section",
                cookies: "cookie-section",
                muffins: "muffin-section",
                brownies: "brownie-section",
                macarons: "macaron-section",
                donuts: "donut-section"
            };

            for (const category in data) {
                const sectionId = categoryToSectionId[category.toLowerCase()];
                if (!sectionId) {
                    console.warn(`No section mapped for category: ${category}`);
                    continue;
                }

                const section = document.querySelector(`#${sectionId} .Food`);
                if (!section) {
                    console.warn(`Section not found: ${sectionId}`);
                    continue;
                }

                data[category].forEach(item => {
                    const card = document.createElement("div");
                    card.classList.add("card");

                    card.innerHTML = `
                        <img class="img" src="${item.image}" alt="${item.name}" />
                        <div class="name-des">
                            <p class="item-name">${item.name}</p>
                            <p class="item-def">${item.description}</p>
                            <div class="all-price-bttn">
                                <span class="item-price">₱${parseFloat(item.price).toFixed(2)}</span>
                                <button class="all-add-bttn"><i class="fas fa-cart-plus"></i></button>
                            </div>
                        </div>
                    `;

                    section.appendChild(card);
                });
            }
        })
        .catch(error => console.error("Error fetching menu:", error));
});
</script>

<script>
  document.addEventListener('click', function (e) {
    // Popular Products
    const popularCard = e.target.closest('.popular-card');
    if (popularCard && !e.target.closest('.add-bttn')) {
      const imgSrc = popularCard.querySelector('img')?.src;
      const name = popularCard.querySelector('.item-name')?.textContent;
      const description = popularCard.querySelector('.popu-item-def')?.textContent;
      const price = popularCard.querySelector('.popular-item-price')?.textContent.replace(/[₱$]/g, '');

      showPopularModal({ imgSrc, name, description, price });
      return;
    }

    // Featured Products
    const featuredCard = e.target.closest('.featured-products-card');
    if (featuredCard && !e.target.closest('.add-to-cart')) {
      const imgSrc = featuredCard.querySelector('img')?.src;
      const name = featuredCard.querySelector('h3')?.textContent;
      const description = featuredCard.querySelector('p')?.textContent;
      const price = featuredCard.querySelector('.price')?.textContent.replace(/[₱$]/g, '');

      showFeaturedModal({ imgSrc, name, description, price });
      return;
    }

    // Special Offer Section
    const specialOffer = e.target.closest('.special-offer-section');
    if (specialOffer) {
      showModal({
        imgSrc: '../images/tart.jpg',
        name: 'Strawberry Surprise',
        description: 'Limited-time sweet with real strawberries and cream.',
        price: '₱1.99'
      });
    }
  });
</script>

<script>
  document.querySelectorAll(".add-to-cart-btn").forEach(button => {
    button.addEventListener("click", () => {
      const productId = button.dataset.id;
      const productName = button.dataset.name;
      const productPrice = button.dataset.price;

      fetch("add_to_cart.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `product_id=${productId}&product_name=${productName}&price=${productPrice}`
      })
      .then(res => res.text())
      .then(message => {
        document.querySelector(".pop-up-modal-content .description").textContent = message;
        document.querySelector(".pop-up-modal").style.display = "flex";
      })
      .catch(err => {
        alert("Error adding to cart.");
      });
    });
  });
</script>


  </body>
</html>






