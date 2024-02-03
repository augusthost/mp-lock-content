<?php

use MP\services\MPEmailService;

if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}

global $mppluginSetting; // we'll need this below

$emailService   = new MPEmailService();
$email_template = $emailService->getTemplate('approved');
$welcome_email  = $email_template['mail_body'];
?>
<style>
    .wrapper {
    background:white;
    padding:1rem;
    box-shadow:0 1px 10px #2020201c;
}
.wrapper .active { color: red; }
.tab_item { display: none; }
.tab_item:first-child { display: block; }

.tabs .tab{
    transition:all ease 0.4s;
    cursor:pointer;
    padding:.5rem 2rem;
    color:#888;
    border-bottom:2px solid #ddd;
}
.tabs .tab:hover{
    background:#f7f9ff;
}
.tabs .tab.active{
    color:#000;
    border-bottom:2px solid #000;
}

.my-2{
    margin:1rem 0 1rem;
}

.my-4{
    margin:2rem 0 2rem;
}

.tab_content .tab_item{
    padding:1rem;
}

.divider{
    border-top:1px dashed #ddd;
    max-width:400px;
    width:100%;
}

.tab_content input{
    min-width: 300px;
    padding:5px;
}

</style>

<div class="wrapper">
    <h1 class="my-4"><?php esc_html_e('Plugin Settings', 'gmi'); ?></h1>

    <form method="post" id="theme-setting" action="<?= $_SERVER['REQUEST_URI']; ?>">
    <?php $mppluginSetting->the_nonce(); ?>

    <div class="tabs">
        <span class="tab">General</span>
        <span class="tab">Email</span>
    </div>
    <div class="tab_content my-2">
        <div class="tab_item">

            <h1>General</h1>
            <div class="divider"></div>

            <table class="form-table">
            <tbody>
            <tr>
				<th scope="row" valign="top">Category to lock.</th>
					<td>
						<label>
                            <select name="<?= $mppluginSetting->get_field_name('locked_cat'); ?>" id="">
                            <?php
                            $categories = get_categories();
                            foreach($categories as $category):
                            ?>
                            <option class="none">None</option>
                            <option value="<?= $category->term_id; ?>"  <?= $mppluginSetting->get_setting('locked_cat') == $category->term_id ? 'selected' : ''; ?> ><?= $category->name; ?></option>
                            <?php endforeach; ?>
                           </select>
						</label>
					</td>
			</tr>
            <tr>
				<th scope="row" valign="top">Number of paragraphs to limit</th>
					<td>
						<label for="paragraph-num">
                            <input name="<?= $mppluginSetting->get_field_name('limit_paragraph_num'); ?>" value="<?= $mppluginSetting->get_setting('limit_paragraph_num'); ?>" id="paragraph-num" />
                        </label>
					</td>
			</tr>
            <tr>
				<th scope="row" valign="top">User Disabled Message</th>
					<td>
						<label for="disable-message">
                            <input name="<?= $mppluginSetting->get_field_name('disabled_message'); ?>" value="<?= $mppluginSetting->get_setting('disabled_message'); ?>" id="disable-message" />
						</label>
					</td>
			</tr>
            </tbody>
            </table>
        </div>
        <div class="tab_item">
            <h1>Email</h1>
            <hr class="my-8" />
            <h4><a href="<?= $mppluginSetting->get_customizer_link(); ?>">Email Template</a></h4>
            <hr class="my-8">
            <h4>Email Content</h4>
             <select name="email-content" id="email-content">
             <option default>Select</option>
             <option value="welcome">Welcome</option>
             </select>
             <div class="my-8 hidden" style="max-width:400px;width:100%;" data-target="welcome">
                <div class="my-2">
                    <h2 class="text-2xl">Welcome Email</h2>
                </div>
                <div class="my-2">
                    <input type="text" name="<?= $mppluginSetting->get_field_name('mail_subject'); ?>" class="w-full" style="max-width:100%; width:100%;" value="<?= !empty($mppluginSetting->get_setting('mail_subject')) ? $mppluginSetting->get_setting('mail_subject') : 'Welcome to MPEVCA'; ?>" placeholder="Email Subject">
                </div>
                <div class="my-2">
                    <textarea rows="4" name="<?= $mppluginSetting->get_field_name('mail_body'); ?>" class="w-full" style="max-width:100%; width:100%;" placeholder="Email Text"><?= !empty($mppluginSetting->get_setting('mail_body')) ? $mppluginSetting->get_setting('mail_body') : $welcome_email; ?></textarea>
                </div>
             </div>
        </div>
    </div>

        <input class="button-primary save-setting-btn" type="submit" value="Save Settings" />
	</form>
</div>

<script>

    jQuery(function($){

        const tabUI = () =>{

            const appendActiveIndexInUrl = (index) => {
                const currentUrl = window.location.href;
        
                const isExit = currentUrl.indexOf('active=') !== -1;
                if (isExit) {
                    // if exist, change index number
                    const newUrl = currentUrl.replace(/(\?|&)active=\d+/, '$1active='+index);
                    window.history.pushState({ path: newUrl }, '', newUrl);
                } 
                
                if(!isExit){
                    // if not exist, append index number
                    const newUrl = currentUrl + (currentUrl.indexOf('?') === -1 ? '?' : '&') + 'active='+index;
                    window.history.pushState({ path: newUrl }, '', newUrl);
                }
            }

            $(".wrapper .tab").click(function() {
                $(".wrapper .tab").removeClass("active").eq($(this).index()).addClass("active");
                $(".tab_item").hide().eq($(this).index()).fadeIn();
                appendActiveIndexInUrl($(this).index());
            });

            // append active class on first load
            const currentUrl = window.location.href;
            const urlSearchParams = new URLSearchParams(new URL(currentUrl).search);
            const activeValue = urlSearchParams.get('active');
            $(".wrapper .tab").eq(activeValue).addClass("active")
            $(".tab_item").hide().eq(activeValue).fadeIn();
        }

        tabUI();


        // Email Selector 
        $("#email-content").on("change", function(){
            const target = $(this).val();
            $(`div[data-target='${target}']`).toggleClass('hidden');
        })


    })
    
</script>