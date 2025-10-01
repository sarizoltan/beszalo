<div class="container my-5">
    <h1 class="mb-4 text-center"><?php echo escape($page_title); ?></h1>

    <?php if (empty($categories_to_display)): ?>
        <div class="alert alert-info text-center">Nincsenek alkategóriák.</div>
    <?php else: ?>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php foreach ($categories_to_display as $category): ?>
                <div class="col">
                    <div class="card h-100 category-card">
                        <a href="categories.php?id=<?php echo $category['id']; ?>" class="category-card-link">
                            <?php 
                                // Alapértelmezett kép, ha nincs megadva
                                $image_url = $category['image_path'] 
                                    ? BASE_URL . '/' . escape($category['image_path']) 
                                    : 'https://via.placeholder.com/400x300.png?text=Nincs+kép';
                            ?>
                            <div class="category-image-wrapper">
                                <img src="<?php echo $image_url; ?>" class="card-img-top" alt="<?php echo escape($category['name']); ?>">
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title"><?php echo escape($category['name']); ?></h5>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>