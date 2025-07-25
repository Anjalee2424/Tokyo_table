<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dessert Recipes | TokyoTable</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <header class="main-header">
    <h1 class="logo">Tokyo<span>Table</span></h1>
    <nav>
      <a href="index.php">Home</a>
      <a href="#">About</a>
      <a href="#">Recipes</a>
      <a href="#">Start Here</a>
    </nav>
  </header>

<section class="recipe-hero">
  <div class="breadcrumb">
    
  </div>

  <div class="hero-content">
    <div class="featured-image">
      <img src="images/dessert-bars.jpg" alt="Raspberry Crumble Bars">
      <p class="featured-text">FEATURED RECIPE:<br>
        <a href="#">RASPBERRY CRUMBLE BARS</a>
      </p>
    </div>
    
    <div class="hero-text">
      <h1>Dessert Recipes</h1>
      <p>We’re not eating dinner just to get to dessert and we’re certainly
        not having dessert FOR dinner but, like, just in case...here are some ideas!
      </p>
    </div>
  </div>
</section>
          

  <!-- Recipe Thumbnails Section -->
  <section class="recipe-thumbnails-section">
    <h2 class="section-title">More Dessert Ideas</h2>
    <div class="recipe-thumbnails">
      <div class="recipe-card" onclick="showDessertDetails('chocolate')">
        <img src="images/chocolate-cake.jpg" alt="Chocolate Cake" />
        <h4>Chocolate Cake</h4>
        <span class="category">Western</span>
      </div>

      <div class="recipe-card" onclick="showDessertDetails('mochi')">
        <img src="images/mochi.jpg" alt="Mochi Ice Cream" />
        <h4>Mochi Ice Cream</h4>
        <span class="category">Japanese</span>
      </div>

      <div class="recipe-card" onclick="showDessertDetails('pudding')">
        <img src="images/pudding.jpg" alt="Matcha Pudding" />
        <h4>Matcha Pudding</h4>
        <span class="category">Custard</span>
      </div>

      <div class="recipe-card" onclick="showDessertDetails('fruitTart')">
        <img src="images/fruit-tart.jpg" alt="Mini Fruit Tart" />
        <h4>Mini Fruit Tart</h4>
        <span class="category">Fruits</span>
      </div>
    </div>

 <!-- Dessert Details Popup -->
    <div id="dessert-details" class="dessert-details" style="display: none;">
      <img id="dessert-image" src="" alt="">
      <h3 id="dessert-title"></h3>
      <button onclick="hideDessertDetails()" class="close-btn">Close ✖</button>

      <div class="ingredients">
        <h4>Ingredients</h4>
        <ul id="ingredients-list"></ul>
      </div>

      <div class="steps">
        <h4>Steps</h4>   
        <ol id="steps-list"></ol>
      </div>
    </div>
  </section>

  <footer>
    <p>&copy; 2025 TokyoTable. All Rights Reserved.</p>
  </footer>

  <script>
    const recipes = {
      chocolate: {
        image: 'images/chocolate-cake.jpg',
        title: 'Decadent Chocolate Cake',
        ingredients: [
          'Flour', 'Cocoa powder', 'Eggs', 'Butter', 'Sugar', 'Baking powder', 'Milk'
        ],
        steps: [
          'Mix dry ingredients in a bowl.',
          'Whisk wet ingredients separately.',
          'Combine both mixtures.',
          'Pour into pan and bake at 180°C for 35 mins.',
          'Let cool and frost as desired.'
        ]
      },
      mochi: {
        image: 'images/mochi.jpg',
        title: 'Mochi Ice Cream Bites',
        ingredients: [
          'Glutinous rice flour', 'Sugar', 'Water', 'Cornstarch', 'Ice cream'
        ],
        steps: [
          'Make mochi dough.',
          'Flatten the dough.',
          'Wrap around ice cream.',
          'Freeze until firm.'
        ]
      },
      pudding: {
        image: 'images/pudding.jpg',
        title: 'Matcha Pudding with Red Bean',
        ingredients: [
          'Milk', 'Cream', 'Sugar', 'Matcha powder', 'Gelatin', 'Red bean paste'
        ],
        steps: [
          'Dissolve matcha in warm milk.',
          'Add gelatin and chill until set.',
          'Top with red bean paste.'
        ]
      },
      fruitTart: {
        image: 'images/fruit-tart.jpg',
        title: 'Mini Fruit Tarts with Custard Cream',
        ingredients: [
          'Tart shells', 'Custard cream', 'Assorted fruits (kiwi, strawberry, blueberry)'
        ],
        steps: [
          'Fill tart shells with custard.',
          'Arrange sliced fruits on top.',
          'Chill before serving.'
        ]
      }
    };

    function showDessertDetails(key) {
      const recipe = recipes[key];
      if (!recipe) return;

      document.getElementById('dessert-image').src = recipe.image;
      document.getElementById('dessert-title').textContent = recipe.title;

      const ingredientsList = document.getElementById('ingredients-list');
      ingredientsList.innerHTML = '';
      recipe.ingredients.forEach(item => {
        const li = document.createElement('li');
        li.textContent = item;
        ingredientsList.appendChild(li);
      });

      const stepsList = document.getElementById('steps-list');
      stepsList.innerHTML = '';
      recipe.steps.forEach(step => {
        const li = document.createElement('li');
        li.textContent = step;
        stepsList.appendChild(li);
      });

      document.getElementById('dessert-details').style.display = 'block';
    }

    function hideDessertDetails() {
      document.getElementById('dessert-details').style.display = 'none';
      document.getElementById('dessert-image').src = '';
      document.getElementById('dessert-title').textContent = '';
      document.getElementById('ingredients-list').innerHTML = '';
      document.getElementById('steps-list').innerHTML = '';
    }
  </script>
</body>
</html>
