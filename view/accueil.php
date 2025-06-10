<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../includes/i18n.php';

$pageTitle = isset($translations['nav_home']) ? $translations['nav_home'] : "Home";

require_once __DIR__ . '/../includes/header.php';

$home_find_sitter_url = get_conditional_link('/pages/find-pet-sitter.php', $base_url);
$home_find_pet_url = get_conditional_link('/pages/find-pet.php', $base_url);

?>

<div class="container">
    <h1><?php echo isset($translations['welcome_home']) ? htmlspecialchars($translations['welcome_home']) : 'Welcome to Leash Lovers!'; ?></h1>

    <?php if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])): ?>
    <p>
        <?php echo isset($translations['hello']) ? htmlspecialchars($translations['hello']) : 'Hello'; ?>, <?php echo htmlspecialchars($_SESSION['first_name']); ?>!
    </p>
    <?php endif; ?>

    <div class="featured-photo-frame">
        <div class="featured-photo-img-content" style="background-image: url('<?php echo $assets_url; ?>/images/home1.png');">
        </div>
    </div>


    <div class="tagline">
        <p><?php echo isset($translations['home_tagline']) ? htmlspecialchars($translations['home_tagline']) : 'For those seeking care or those who love to care - join a community built for pets!'; ?></p>
    </div>

    <div class="cta-tiles">
        <div class="cta-card">
            <div class="cta-img-bg" style="background-image: url('<?php echo $assets_url; ?>/images/find-a-pet-sitter-image.png');"></div>
            <a href="<?php echo $home_find_sitter_url; ?>" class="cta-btn"><?php echo isset($translations['find_sitter_button']) ? htmlspecialchars($translations['find_sitter_button']) : 'Find a Pet Sitter'; ?></a>
        </div>
        <div class="cta-card">
            <div class="cta-img-bg" style="background-image: url('<?php echo $assets_url; ?>/images/start-pet-sitting-image.png');"></div>
            <a href="<?php echo $home_find_pet_url; ?>" class="cta-btn"><?php echo isset($translations['find_pet_button']) ? htmlspecialchars($translations['find_pet_button']) : 'Find a Pet to Sit'; ?></a>
        </div>
    </div>

    <section class="home-section featured-reviews-section">
        <h2><?php echo $translations['home_featured_reviews_title'] ?? 'What our users say'; ?></h2>
        <div class="reviews-grid">
            <div class="review-item">
                <div class="review-image-placeholder">
                     <img src="<?php echo $assets_url; ?>/images/review1-dog.jpeg" alt="<?php echo $translations['home_review_alt_1'] ?? 'Review 1'; ?>">
                </div>
                <div class="review-text-placeholder">
                    <p>"Max had the best time with Sarah! She sent daily updates and photos. We felt so at ease knowing he was in great hands. Will definitely book again!"</p>
                    <span>- Jessica K. & Max (Golden Retriever)</span>
                </div>
            </div>
            <div class="review-item">
                <div class="review-image-placeholder">
                    <img src="<?php echo $assets_url; ?>/images/review2-cat.jpeg" alt="<?php echo $translations['home_review_alt_2'] ?? 'Review 2'; ?>">
                </div>
                <div class="review-text-placeholder">
                     <p>"Finding a trustworthy sitter for my shy cat, Luna, was a challenge until I found LeashLovers. David was patient and gentle, and Luna warmed up to him quickly!"</p>
                    <span>- Michael B. & Luna (Siamese Cat)</span>
                </div>
            </div>
            <div class="review-item">
                <div class="review-image-placeholder">
                    <img src="<?php echo $assets_url; ?>/images/review3-rabbit.jpeg" alt="<?php echo $translations['home_review_alt_3'] ?? 'Review 3'; ?>">
                </div>
                <div class="review-text-placeholder">
                    <p>"Our rabbit, Thumper, requires special care, and we were thrilled with the attention to detail from our sitter, Emily. She followed all instructions perfectly."</p>
                    <span>-  Aisha R. & Thumper (Dutch Rabbit)</span>
                </div>
            </div>
        </div>
    </section>

    <section class="home-section peace-of-mind-section">
        <h2><?php echo $translations['home_peace_of_mind_title'] ?? 'Leave with peace of mind'; ?></h2>
        <div class="features-grid three-cols">
            <div class="feature-item">
                <img src="<?php echo $assets_url; ?>/images/read-feedback.png" alt="<?php echo $translations['home_read_feedback_alt'] ?? 'Read Feedback Icon'; ?>" class="feature-icon read-feedback-icon">
                <div class="feature-text-content">
                    <h3><?php echo $translations['home_read_feedback_title'] ?? 'Read feedback'; ?></h3>
                    <p><?php echo $translations['home_read_feedback_desc'] ?? 'Browse ratings and reviews to find the perfect pet sitter. Transparent feedback helps you make the best choice for your pet’s care.'; ?></p>
                </div>
            </div>
            <div class="feature-item">
                <img src="<?php echo $assets_url; ?>/images/save-with-shared-pet-sitting.png" alt="<?php echo $translations['home_shared_sitting_alt'] ?? 'Shared Pet Sitting Icon'; ?>" class="feature-icon shared-sitting-icon">
                <div class="feature-text-content">
                    <h3><?php echo $translations['home_shared_sitting_title'] ?? 'Save with Shared Pet Sitting'; ?></h3>
                    <p><?php echo $translations['home_shared_sitting_desc'] ?? 'Save on pet sitting by teaming up with neighbors! By grouping together, you can hire a single sitter for multiple pets, reducing the overall cost while ensuring your furry friends get the attention they deserve.'; ?></p>
                </div>
            </div>
            <div class="feature-item">
                <img src="<?php echo $assets_url; ?>/images/find-a-vet.png" alt="<?php echo $translations['home_find_vet_alt'] ?? 'Find a Vet Icon'; ?>" class="feature-icon find-vet-icon">
                <div class="feature-text-content">
                    <h3><?php echo $translations['home_find_vet_title'] ?? 'Find a Vet'; ?></h3>
                    <p><?php echo $translations['home_find_vet_desc'] ?? 'Need urgent care for your pet? We provide direct links to trusted veterinary service websites, helping you connect quickly to professional care when your pet needs it the most.'; ?></p>
                </div>
            </div>
        </div>
    </section>

    <section class="home-section how-it-works-detailed-section">
        <h2><?php echo $translations['home_how_it_works_detailed_title'] ?? 'How does it work?'; ?></h2>
        <div class="features-grid three-cols">
            <div class="feature-item">
                <img src="<?php echo $assets_url; ?>/images/find-or-offer.png" alt="<?php echo $translations['home_find_offer_alt'] ?? 'Find or Offer Services Icon'; ?>" class="feature-icon find-offer-icon">
                <div class="feature-text-content">
                    <h3><?php echo $translations['home_find_offer_title'] ?? 'Find or Offer Services'; ?></h3>
                    <p><?php echo $translations['home_find_offer_desc'] ?? 'Post your pet sitting ad or search for a trusted sitter for your pets near you. Communicate directly through messaging or calls to connect with the right match.'; ?></p>
                </div>
            </div>
            <div class="feature-item">
                <img src="<?php echo $assets_url; ?>/images/manage-and-schedule.png" alt="<?php echo $translations['home_manage_schedule_alt'] ?? 'Manage Contacts and Schedule Jobs Icon'; ?>" class="feature-icon manage-schedule-icon">
                <div class="feature-text-content">
                    <h3><?php echo $translations['home_manage_schedule_title'] ?? 'Manage Contacts and Schedule Jobs'; ?></h3>
                    <p><?php echo $translations['home_manage_schedule_desc'] ?? 'Update your profile and availability to manage upcoming pet sitting tasks, whether you’re offering services or looking for a sitter for your pets.'; ?></p>
                </div>
            </div>
            <div class="feature-item">
                <img src="<?php echo $assets_url; ?>/images/payment-icon.png" alt="<?php echo $translations['home_subscribe_transact_alt'] ?? 'Subscribe & Transact Securely Icon'; ?>" class="feature-icon payment-icon">
                <div class="feature-text-content">
                    <h3><?php echo $translations['home_subscribe_transact_title'] ?? 'Subscribe & Transact Securely'; ?></h3>
                    <p><?php echo $translations['home_subscribe_transact_desc'] ?? 'Start with a convenient subscription to connect. Owners finalize bookings with secure online payments (15% fee, multiple payment options). Sitters enjoy hassle-free payouts for their valued services.'; ?></p>
                </div>
            </div>
        </div>
    </section>

    <section class="home-section why-us-section">
        <h2><?php echo $translations['home_why_us_title'] ?? 'Why us then?'; ?></h2>
        <div class="why-us-text-container">
            <p><?php echo $translations['home_why_us_desc'] ?? 'We prioritize your pet’s safety and your peace of mind. All sitters on our platform are ID-verified and background-checked to ensure trust and reliability. Each booking includes basic pet insurance covering accidents, emergencies, and property damage, with optional add-ons like vet fee coverage and liability protection. With secure in-app messaging, honest reviews, and flexible scheduling, we make finding quality pet care simple, transparent, and worry-free.'; ?></p>
        </div>
    </section>

    <section class="home-section ready-to-start-section">
        <h2><?php echo $translations['home_ready_start_title'] ?? 'Ready to get started?'; ?></h2>
        <p><?php echo $translations['home_ready_start_desc'] ?? 'Join our global community today and begin connecting with pet owners or sitters for trusted care and give your pet the best.'; ?></p>
    </section>

</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>