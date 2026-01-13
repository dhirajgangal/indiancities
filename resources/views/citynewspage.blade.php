<!-- News Section -->
<section class="news-section">
    <div class="news-section-container">
        <!-- Left column -->
        <div class="news-left">
            <h2 class="daily-news-title"> <?php echo $city->name; ?> के घाव</h2>
            <?php foreach ($news as $item): ?>
                <article class="mini-card">
                    <img src="<?php echo $item->thumbnail; ?>" alt="story thumbnail">
                    <a href="<?php echo route('city.news', ['slug' => $city->slug]); ?>" class="mini-title">
                        <?php echo $item->title; ?>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
        <!-- Start Center column -->
        <div class="news-center">
            <h2 class="daily-news-title"> दैनिक समाचार</h2>

            <div class="daily-news-list">
                <?php foreach ($news as $item): ?>
                    <a href="<?php echo route('city.news', ['slug' => $city->slug]); ?>" class="daily-news-item">
                        <div class="daily-news-text">
                            <h3><?php echo $item->title; ?></h3>
                            <p><?php echo $item->excerpt; ?></p>
                        </div>
                        <div class="daily-news-img">
                            <img src="<?php echo $item->image; ?>" alt="<?php echo $item->title; ?>">
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- End Center column -->

        <!-- Right column -->
        <div>
            <img src="./assets/image 11 (1).png" alt="city-advertisement" class="city-advertisement">
        </div>
    </div>
</section>