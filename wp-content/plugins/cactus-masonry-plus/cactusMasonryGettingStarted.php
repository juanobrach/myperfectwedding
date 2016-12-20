<?php

function cactus_masonry_plus_intro() {
	add_plugins_page('Getting Started with Cactus Masonry Plus', 'Cactus Masonry Plus', 'edit_posts', 'cactus_masonry_plus_intro', 'render_cactus_masonry_plus_intro');
}

function render_cactus_masonry_plus_intro()
{
?>
	<style scoped="true">
		#cactusMasonryIntro {
			box-sizing: border-box;
			margin-right: 20px;
		}
		#cactusMasonryIntro code {
			display: inline-block;
		}
		#cactusMasonryIntro .centered {
			text-align: center;
		}
		#cactusMasonryIntro .section {
			margin-bottom: 65px;
		}
		#cactusMasonryIntro .menuTitle {
			padding-top: 5px;
		}
		#cactusMasonryIntro .links {
			overflow: hidden;
			box-sizing: border-box;
		}
		#cactusMasonryIntro .links div {
			width: 33%;
			float: left;
			padding: 0 20px 0 20px;
			text-align: center;
			box-sizing: border-box;
		}
		#cactusMasonryIntro .links a {
			font-size: 1.3em;
			font-weight: 100;
			text-decoration: none;
		}
		@media (max-width: 765px) {
			#cactusMasonryIntro {
				margin-right: 10px;
			}
		}
		@media (max-width: 500px) {
			#cactusMasonryIntro .menuTitle {
				text-align: center;
			}
			#cactusMasonryIntro .links div {
				width: auto;
				float: none;
				padding: 3px 20px;
			}
		}
	</style>
	<div id="cactusMasonryIntro">
		<div class="section">
			<div class="menuTitle">
				<span title="Too long; Didn't read">
					TL;DR?
				</span>
				Quick Links:
			</div>
			<div class="links">
				<div>
					<a href="http://cactus.cloud/masonryplus" target="_blank">
						Documentation
					</a>
				</div>
				<div>
					<a href="http://cactus.cloud/masonryplus/cactus-masonry-plus/shortcode-builder" target="_blank">
						The Shortcode Builder
					</a>
				</div>
				<div>
					<a href="http://support.cactus.cloud" target="_blank">
						Get Support
					</a>
				</div>
			</div>
		</div>
		<div class="section">
			<h1 class="centered">
				Cactus Masonry Plus
			</h1>
			<h2 class="centered">
				The Quick Start Guide
			</h2>
			<p>
				Hey there, and thanks for trying Cactus Masonry Plus.  This is just a quick guide to help you make some amazing galleries right away.
			<p>
		</div>
		<div class="section">
			<h2>
				A short tale about &#91;Short Codes&#93;
			</h2>
			<p>
				Cactus Masonry Plus is controlled using shortcodes.  Shortcodes are small lines of text enclosed within square brackets.  The most basic shortcode looks like this <code>&#91;cactusMasonry&#93;</code>.
			</p>
			<p>
				You can place a shortcode anywhere your theme will allow.  Most themes will have shortcodes enabled for their posts and pages, but you can also enable shortcodes anywhere else on your site, including your header, footer, and widgets.  It’s all up to your theme!
			</p>
			<p>
				So, all you do is build your shortcode, place it wherever you want your gallery to appear, and publish or preview the changes to see your new gallery.
			</p>
		</div>
		<div class="section">
			<h2>
				Building Your Shortcode
			</h2>
			<p>
				Your shortcode can (and really should) be customized with a whole bunch of parameters.  For example, the width parameter can be used to set the <code>width</code> of each brick in your gallery to a given size.  For example <code>&#91;cactusMasonry width="300px"&#93;</code> will create a gallery with 300 pixel wide images.
			</p>
			<p>
				Of course, there are a whole bunch of other parameters, and it will be difficult and time consuming to learn them all.  So, that’s why we have provided an interactive Shortcode Builder.  Select the options you want, preview the results, and when you’re happy, paste the shortcode onto your site.
			</p>
			<h3 class="centered">
				<a href="http://cactus.cloud/masonryplus/cactus-masonry-plus/shortcode-builder" target="_blank">
					Click Here to Access the Shortcode Builder
				</a>
			</h3>
		</div>
		<div class="section">
			<h2>
				Some Tips for Getting Started
			</h2>
			<p>
				It can be a bit daunting when getting started, but I think you’ll really come to like the plugin.  Still, here are some tips to get your first gallery built in no time!
			</p>
			<br/>
			<strong>
				1. Use the
				<a href="http://cactus.cloud/masonryplus/cactus-masonry-plus/shortcode-builder" target="_blank">
					Shortcode Builder
				</a>
			</strong>
			<p>
				No, it's not a trap - it's just the tool you need to get your gallery up and running fast!  Here are some styling ideas to help you get the best results!
			</p>
			<br/>
			<strong>
				2. Specify a Brick Width
			</strong>
			<p>
				Galleries with a uniform brick width tend to look better.  This is not a rule and it’s certainly not set in stone, but it does generally prove true.
			</p>
			<p>
				You can set either a pixel value (e.g. 300px, 550px, etc.) or a percentage value (e.g. 33.3333%, 50%, 25%).
			</p>
			<p>
				You can even specify you brick height too.  If you do, Cactus Masonry Plus will crop your images to avoid stretching them out of proportion.
			</p>
			<p>
				Also remember, that you can set maximum and minimum heights and widths too.  This will enable you to easily build a mobile responsive gallery.
			</p>
			<br/>
			<strong>
				3. Filter Your Gallery
			</strong>
			<p>
				Remember that you can filter and sort the contents of your gallery by a whole bunch of criteria.  Check out the Shortcode Builder to see all the options available.
			</p>
			<br/>
			<strong>
				4. Remember You Can Apply CSS
			</strong>
			<p>
				Cactus Masonry Plus has a (growing) number of selectable themes that you can choose between in the Shortcode Builder.  All the included themes are as minimalistic as possible, leaving you free to add your own CSS styling.  You can even select no theme at all if you wish to restyle your gallery from scratch.
			</p>
			<br/>
			<strong>
				5. Feel Free to Ask Questions
			</strong>
			<p>
				Help is just a stone’s throw away… or at least several dozen mouse clicks and keystrokes away.  If you have a feature request, have found a bug, or have just gotten a little stuck, contact our support and we’ll do all we can to help!
			</p>
		</div>
		<div class="section">
			<h2>
				Getting Support
			</h2>
			<p>
				If you do get stuck, have a feature request, or have found a bug, get in touch and we'll sort it out.
			</p>
			<h3 class="centered">
				<a href="http://support.cactus.cloud" target="_blank">
					Click Here For Support
				</a>
			</h3>
		</div>
		<div class="section">
			<h2>
				Giving Support
			</h2>
			<p>
				If you liked the plugin, thought that our support was great, or just want to say thanks, feel free to do so by 
				<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=forum%40cactus%2ecloud&lc=AU&item_name=cactus%2ecloud&item_number=masonry&currency_code=AUD&" target="_blank">
					donating
				</a> 
				however much you feel is fair, or by leaving feedback on the WordPress plugin forums.
			</p>
		</div>
	</div>
	
<?php
}
?>