<?php

class WDTIViewFeatured_plugins_twitter_integration {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  private $model;


  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function __construct($model) {
    $this->model = $model;
  }
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function display() {
    ?>
    <div id="main_featured_plugins_page">
      <table align="center" width="90%" style="margin-top: 0px;border-bottom: rgb(111, 111, 111) solid 1px;">
        <tr>
          <td colspan="2" style="height: 40px; padding: 30px 0px 0px 0px;">
            <h3 style="margin: 0px;font-family:Segoe UI;padding-bottom: 15px;color: rgb(111, 111, 111); font-size:18pt;">Featured Plugins</h3>
          </td>
          <td  align="right" style="font-size:16px;"></td>
        </tr>
      </table>

      <div class="featured_header">
        <div>
          <a target="_blank" href="https://web-dorado.com/wordpress-plugins.html?source=eventcalendarwd">
            <h1>GET ALL 26 PLUGINS</h1>
            <h1 class="get_plugins">FOR $99 ONLY <span>- SAVE 80%</span></h1>
          </a>
        </div>

        <form method="post">
          <ul id="featured-plugins-list">
            <!--1-->
            <li class="form-maker">
              <div class="product"></div>
              <div class="title">
                <strong class="heading">Form Maker</strong>
              </div>
              <div class="description">
                <p>Form Maker is a modern and advanced tool for creating WordPress forms easily and fast.</p>
              </div>
              <a target="_blank" href="https://web-dorado.com/products/wordpress-form.html" class="download">Download plugin &#9658;</a>
            </li>
            <!--2-->
            <li class="photo-gallery ">
              <div class="product"></div>
              <div class="title">
                <strong class="heading">Photo Gallery</strong>
              </div>
              <div class="description">
                <p>Photo Gallery is a fully responsive WordPress Gallery plugin with advanced functionality. </p>
              </div>
              <a target="_blank" href="https://web-dorado.com/products/wordpress-photo-gallery-plugin.html" class="download">Download plugin &#9658;</a>
            </li>
            <!--3-->
            <li class="events-calendar-wd">
              <div class="product"></div>
              <div class="title">
                <strong class="heading">Event Calendar WD</strong>
              </div>
              <div class="description">
                <p>Organize and publish your events in an easy and elegant way using Event Calendar WD.</p>
              </div>
              <a target="_blank" href="https://web-dorado.com/products/wordpress-event-calendar-wd.html" class="download">Download plugin &#9658;</a>
            </li>
            <!--4-->
            <li class="slider_wd">
              <div class="product"></div>
              <div class="title">
                <strong class="heading">Slider WD</strong>
              </div>
              <div class="description">
                <p>Create responsive, highly configurable sliders with various effects for your WordPress site. </p>
              </div>
              <a target="_blank" href="https://web-dorado.com/products/wordpress-slider-plugin.html" class="download">Download plugin &#9658;</a>
            </li>
            <!--5-->
            <li class="google-maps">
              <div class="product"></div>
              <div class="title">
                <strong class="heading">Google Maps WD</strong>
              </div>
              <div class="description">
                <p>Google Maps WD is an intuitive tool for creating Google maps with advanced markers, custom layers and overlays for your website.</p>
              </div>
              <a target="_blank" href="https://web-dorado.com/products/wordpress-google-maps-plugin.html" class="download">Download plugin &#9658;</a>
            </li>
            <!--6-->
            <li class="google-analytics">
              <div class="product"></div>
              <div class="title">
                <strong class="heading">Google Analytics WD</strong>
              </div>
              <div class="description">
                <p>WD Google Analytics is a user-friendly all in one plugin, which allows to manage and monitor your website analytics from WordPress dashboard.</p>
              </div>
              <a target="_blank" href="https://web-dorado.com/products/wordpress-google-analytics-plugin.html" class="download">Download plugin &#9658;</a>
            </li>
            <!--7-->
            <li class="ecommerce-wd">
              <div class="product"></div>
              <div class="title">
                <strong class="heading">ecommerce wd</strong>
              </div>
              <div class="description">
                <p>Ecommerce WD is a highly-functional, user friendly WordPress Ecommerce plugin, which is perfect for developing online stores for any level of complexity.</p>
              </div>
              <a target="_blank" href="https://web-dorado.com/products/wordpress-ecommerce.html" class="download">Download plugin &#9658;</a>
            </li>
            <!--8-->
            <li class="mailchimp-wd">
              <div class="product"></div>
              <div class="title">
                <strong class="heading">MailChimp WD</strong>
              </div>
              <div class="description">
                <p>MailChimp WD is a functional plugin developed to create MailChimp subscribe/unsubscribe forms and manage lists from your WordPress site.</p>
              </div>
              <a target="_blank" href="https://web-dorado.com/products/wordpress-mailchimp-wd.html" class="download">Download plugin &#9658;</a>
            </li>
            <!--9-->
            <li class="facebook-feed">
              <div class="product"></div>
              <div class="title">
                <strong class="heading">Facebook Feed WD</strong>
              </div>
              <div class="description">
                <p>Facebook Feed WD is a completely customizable, responsive solution to help you display your Facebook feed on your WordPress website. </p>
              </div>
              <a target="_blank" href="https://web-dorado.com/products/wordpress-facebook-feed-plugin.html" class="download">Download plugin &#9658;</a>
            </li>
            <!--10-->
            <li class="instagram-wd">
              <div class="product"></div>
              <div class="title">
                <strong class="heading">Instagram Feed WD</strong>
              </div>
              <div class="description">
                <p>Instagram Feed WD plugin allows to display image feeds from single or multiple Instagram accounts on a WordPress site.</p>
              </div>
              <a target="_blank" href="https://web-dorado.com/products/wordpress-instagram-feed-wd.html" class="download">Download plugin &#9658;</a>
            </li>
            <!--11-->
            <li class="post-slider">
              <div class="product"></div>
              <div class="title">
                <strong class="heading">Post Slider</strong>
              </div>
              <div class="description">
                <p>Post Slider WD is designed to show off the selected posts of your website in a slider. </p>
              </div>
              <a target="_blank" href="https://web-dorado.com/products/wordpress-post-slider-plugin.html" class="download">Download plugin &#9658;</a>
            </li>
            <!--12-->
            <li class="ad-manager">
              <div class="product"></div>
              <div class="title">
                <strong class="heading">Ad Manager WD</strong>
              </div>
              <div class="description">
                <p>Ad Manager WD plugin is the easiest way to place banner ads on your WordPress website.</p>
              </div>
              <a target="_blank" href="https://web-dorado.com/products/wordpress-ad-manager-wd.html" class="download">Download plugin &#9658;</a>
            </li>
            <!--13-->
            <li class="contact-maker">
              <div class="product"></div>
              <div class="title">
                <strong class="heading">Contact Form Maker</strong>
              </div>
              <div class="description">
                <p>WordPress Contact Form Maker is an advanced and easy-to-use tool for creating forms.</p>
              </div>
              <a target="_blank" href="https://web-dorado.com/products/wordpress-contact-form-maker-plugin.html" class="download">Download plugin &#9658;</a>
            </li>
            <!--14-->
            <li class="contact_form_bulder">
              <div class="product"></div>
              <div class="title">
                <strong class="heading">Contact Form Builder</strong>
              </div>
              <div class="description">
                <p>Contact Form Builder is the best tool for quickly arranging a contact form for your clients and visitors. </p>
              </div>
              <a target="_blank" href="https://web-dorado.com/products/wordpress-contact-form-builder.html" class="download">Download plugin &#9658;</a>
            </li>
            <!--15-->
            <li class="faq-wd">
              <div class="product"></div>
              <div class="title">
                <strong class="heading">FAQ WD</strong>
              </div>
              <div class="description">
                <p>The FAQ WD plugin will help to add categorizes and include questions in each category.</p>
              </div>
              <a target="_blank" href="https://web-dorado.com/products/wordpress-faq-wd.html" class="download">Download plugin &#9658;</a>
            </li>
            <!--17-->
            <li class="spider-calendar">
              <div class="product"></div>
              <div class="title">
                <strong class="heading">Spider Calendar</strong>
              </div>
              <div class="description">
                <p>Spider Event Calendar is a highly configurable product which allows you to have multiple organized events.</p>
              </div>
              <a target="_blank" href="https://web-dorado.com/products/wordpress-calendar.html" class="download">Download plugin &#9658;</a>
            </li>
            <!--18-->
            <li class="facebook">
              <div class="product"></div>
              <div class="title">
                <strong class="heading">Spider Facebook</strong>
              </div>
              <div class="description">
                <p>Spider Facebook is a WordPress integration tool for Facebook.It includes all the available Facebook social plugins and widgets.</p>
              </div>
              <a target="_blank" href="https://web-dorado.com/products/wordpress-facebook.html" class="download">Download plugin &#9658;</a>
            </li>
            <!--19-->
            <li class="catalog">
              <div class="product"></div>
              <div class="title">
                <strong class="heading">Spider Catalog</strong>
              </div>
              <div class="description">
                <p>Spider Catalog for WordPress is a convenient tool for organizing the products represented on your website into catalogs.</p>
              </div>
              <a target="_blank" href="https://web-dorado.com/products/wordpress-catalog.html" class="download">Download plugin &#9658;</a>
            </li>
            <!--20-->
            <li class="player">
              <div class="product"></div>
              <div class="title">
                <strong class="heading">Spider Video Player</strong>
              </div>
              <div class="description">
                <p>Spider Video Player for WordPress is a Flash & HTML5 video player plugin that allows you to easily add videos to your website with the possibility</p>
              </div>
              <a target="_blank" href="https://web-dorado.com/products/wordpress-player.html" class="download">Download plugin &#9658;</a>
            </li>
            <!--21-->
            <li class="twitter-widget">
              <div class="product"></div>
              <div class="title">
                <strong class="heading">Widget Twitter</strong>
              </div>
              <div class="description">
                <p>The Widget Twitter plugin lets you to fully integrate your WordPress site with your Twitter account.</p>
              </div>
              <a target="_blank" href="https://web-dorado.com/products/wordpress-twitter-integration-plugin.html" class="download">Download plugin &#9658;</a>
            </li>
            <!--22-->
            <li class="contacts">
              <div class="product"></div>
              <div class="title">
                <strong class="heading">Spider Contacts</strong>
              </div>
              <div class="description">
                <p>Spider Contacts helps you to display information about the group of people more intelligible, effective and convenient.</p>
              </div>
              <a target="_blank" href="https://web-dorado.com/products/wordpress-contacts-plugin.html" class="download">Download plugin &#9658;</a>
            </li>
            <!--23-->
            <li class="faq">
              <div class="product"></div>
              <div class="title">
                <strong class="heading">Spider FAQ</strong>
              </div>
              <div class="description">
                <p>The Spider FAQ WordPress plugin is for creating an FAQ (Frequently Asked Questions) section for your website.</p>
              </div>
              <a target="_blank" href="https://web-dorado.com/products/wordpress-faq-plugin.html" class="download">Download plugin &#9658;</a>
            </li>
            <!--24-->
            <li class="folder_menu">
              <div class="product"></div>
              <div class="title">
                <strong class="heading">Folder Menu</strong>
              </div>
              <div class="description">
                <p>Folder Menu Vertical is a WordPress Flash menu module for your website, designed to meet your needs and preferences. </p>
              </div>
              <a target="_blank" href="https://web-dorado.com/products/wordpress-menu-vertical.html" class="download">Download plugin &#9658;</a>
            </li>
            <!--25-->
            <li class="zoom">
              <div class="product"></div>
              <div class="title">
                <strong class="heading">Zoom</strong>
              </div>
              <div class="description">
                <p>Zoom enables site users to resize the predefined areas of the web site.</p>
              </div>
              <a target="_blank" href="https://web-dorado.com/products/wordpress-zoom.html" class="download">Download plugin &#9658;</a>
            </li>
            <!--26-->
            <li class="random_post">
              <div class="product"></div>
              <div class="title">
                <strong class="heading">Spider Random post</strong>
              </div>
              <div class="description">
                <p>Spider Random Post is a small but very smart solution for your WordPress web site. </p>
              </div>
              <a target="_blank" href="https://web-dorado.com/products/wordpress-random-post.html" class="download">Download plugin &#9658;</a>
            </li>
            <li class="ad-manager">
              <div class="product"></div>
              <div class="title">
                <strong class="heading">AD MANAGER WD</strong>
              </div>
              <div class="description">
                <p>Thinking of ways to monetize your WordPress website with ads? Now you can do it without any difficulty.</p>
              </div>
              <a target="_blank" href="https://web-dorado.com/products/wordpress-ad-manager-wd.html" class="download">Download plugin &#9658;</a>
            </li>
            <li class="youtube-wd">
              <div class="product"></div>
              <div class="title">
                <strong class="heading">YOUTUBE WD</strong>
              </div>
              <div class="description">
                <p>Adding YouTube videos, channels and playlists to your WordPress website is super easy with YouTube WD plugin.</p>
              </div>
              <a target="_blank" href="https://web-dorado.com/products/wordpress-youtube-plugin.html" class="download">Download plugin &#9658;</a>
            </li>
          </ul>
        </form>
      </div>
    </div>
    <?php
  }
  ////////////////////////////////////////////////////////////////////////////////////////
  // Getters & Setters                                                                  //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Private Methods                                                                    //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}