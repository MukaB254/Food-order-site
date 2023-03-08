   <!-- fOOD sEARCH Section Starts Here -->
   <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITE_URL;?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>