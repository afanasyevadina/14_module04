<?php
get_header();
?>
    <article class="animatable">
        <h2>
            <span><?= get_the_title() ?></span>
        </h2>
        <p>
            <?= get_the_content() ?>
        </p>
    </article>
    <section class="grid">
        <?php foreach (get_posts(['posts_per_page' => '-1']) as $post) : ?>
            <div class="animatable">
                <img src="<?= get_the_post_thumbnail_url($post->ID) ?>" alt="">
            </div>
        <?php endforeach; ?>
    </section>
    <div id="reservation">
        <article class="animatable">
            <h2><span>Reservation/</span><br><span>Зарегаться</span></h2>
            <p>
                Заполните и мы будем ждать вас с еще большей радостью!
            </p>
        </article>
        <div class="form-wrapper animatable">
            <form action="<?= admin_url('admin-post.php') ?>" id="reservation-form" novalidate>
                <div>
                    <label for="name">Name/ Имя</label>
                    <input type="text" name="name" id="name" placeholder="Mrs. Smith" required>
                </div>
                <div>
                    <label for="email">Email/ Почта</label>
                    <input type="email" name="email" id="email" required placeholder="mrs.smith@wsk.org">
                </div>
                <div class="form-grid">
                    <div>
                        <label for="date">Date/ Когда?</label>
                        <input type="date" name="date" id="date" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div>
                        <label for="time">Time/ Во сколько?</label>
                        <input type="time" name="time" id="time" required value="20:00">
                    </div>
                </div>
                <div>
                    <label for="visitors_count">Number of visitors/ Сколько вас?</label>
                    <input type="number" name="visitors_count" id="visitors_count" value="2" required>
                </div>
                <div class="alert"></div>
                <button>SEND</button>
            </form>
        </div>
    </div>
<?php
get_footer();
?>