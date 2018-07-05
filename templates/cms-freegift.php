<div class="head-logo">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/cropped-GIFT-white.png" />
</div>

<div class="step" id="step1">
    <h1>CMS: Add a free Gift</h1>
    <p>"Free Gifts" are gift experiences from the venue to each visitor (unlike gifts from visitor to visitor). In the <a href="https://toolkit.gifting.digital/framework-pages/gift-exchange-app/" target="_blank">Gift Exchange</a> app, your free gift is offered to each user when they select your particular venue: in this way, the free gift is a useful introduction to the venue and tends to frame the way the users will make their own gifts subsequently.</p>
    <p>If you would like to set up a free gift for your venue, fill out the form below.</p>
    <h2>Gift card</h2>
    <p>How will you introduce the experience that you are gifting to your visitors? Keep the introduction brief (e.g. 1-3 sentences). The introduction might describe the objects that the experience includes, an overarching theme for the experience, or a perspective that you want the visitor to take while they are exploring.</p>
    <textarea id="giftcard"></textarea>
    <h2>Objects</h2>
    <p>An experience consists of three objects and three special messages that you have left for them at those objects. It may help to think about one object as the start of the experience, one object as the middle, and one as the end.</p>
    <h2>Object 1: the Start</h2>
    <p>Choose an object from those registered in your venue. You may need to return to the previous screen to add more locations and objects before you complete the free gift.</p>
    <p>Now write a message to be "wrapped up" with the object. The visitor will need to find the object in your venue first: by finding the object they will "unwrap" and be able to read the associated message.</p>
    <textarea id="message1"></textarea>
    <h2>Object 2: the Middle</h2>
    <p>Object:</p>
    <p>Message:</p>
    <textarea id="message2"></textarea>
    <h2>Object 3: the End</h2>
    <p>Object:</p>
    <p>Message:</p>
    <textarea id="message3"></textarea>
    <h2>Done?</h2>
    <p style="padding-top: 30px;">When this is complete, press the button labelled "Publish".</p>
    <p><button>Add the free gift</button></p>
</div>

<div style="position: fixed; right: 20px; bottom: 20px;">
    <button onclick="window.history.back();">Back</button>
</div>

<script>
jQuery(function($) {
	$.backstretch('<?php echo get_stylesheet_directory_uri(); ?>/images/backstretch/index-project.jpg');

    $('#step1').fadeIn();
});
</script>