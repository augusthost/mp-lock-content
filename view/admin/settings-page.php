<?php

use MP\services\MPEmailService;

if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}

global $mppluginSetting; // we'll need this below

$emailService  = new MPEmailService();
$welcome_email = $emailService->getTemplate('approved');
$welcome_email = $welcome_email['mail_body'];


$verify_email = $emailService->getTemplate('verification');
$verify_email = $verify_email['mail_body'];


$forgot_email = $emailService->getTemplate('forgot_pass');
$forgot_email = $forgot_email['mail_body'];


function get_test_email_template($type){
    return '<div class="my-2 flex gap-2 test-email">
    <input type="text" name="test_email" placeholder="example@gmail.com" data-template="'.$type.'">
    <button type="button" class="send-test button-primary">Send Test</button>
    <p><small>Please save settings before sending test.</small></p>
    </div>';    
}
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
                            <option class="none">None</option>
                            <?php
                            $categories = get_categories();
                            foreach($categories as $category):
                            ?>
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
                            <input style="min-width:20px;width: 48px;" name="<?= $mppluginSetting->get_field_name('limit_paragraph_num'); ?>" value="<?= $mppluginSetting->get_setting('limit_paragraph_num'); ?>" id="paragraph-num" />
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
             <select name="email-content" id="email-content" style="max-width:400px;width:100%;">
             <option default>Select</option>
             <option value="welcome">Welcome</option>
             <option value="verification">Verification</option>
             <option value="forgot_pass">Forgot Password</option>
             </select>


             <!-- Welcome -->
             <div class="my-8 hidden" style="max-width:400px;width:100%;" data-target="welcome">
                <div class="my-2">
                    <h2 class="text-2xl">Welcome Email</h2>
                </div>
                <div class="my-2">
                    <input type="text" name="<?= $mppluginSetting->get_field_name('welcome_mail_subject'); ?>" class="w-full" style="max-width:100%; width:100%;" value="<?= !empty($mppluginSetting->get_setting('welcome_mail_subject')) ? $mppluginSetting->get_setting('welcome_mail_subject') : 'Welcome to MPEVCA'; ?>" placeholder="Email Subject">
                </div>
                <div class="my-2">
                    <textarea rows="4" name="<?= $mppluginSetting->get_field_name('welcome_mail_body'); ?>" class="w-full" style="max-width:100%; width:100%; min-height:200px;" placeholder="Email Text"><?= !empty($mppluginSetting->get_setting('welcome_mail_body')) ? $mppluginSetting->get_setting('welcome_mail_body') : $welcome_email; ?></textarea>
                </div>
                <?= get_test_email_template('welcome'); ?>
             </div>

             <!-- Verification -->
             <div class="my-8 hidden" style="max-width:400px;width:100%;" data-target="verification">
                <div class="my-2">
                    <h2 class="text-2xl">Verification Email</h2>
                </div>
                <div class="my-2">
                    <input type="text" name="<?= $mppluginSetting->get_field_name('verification_mail_subject'); ?>" class="w-full" style="max-width:100%; width:100%;" value="<?= !empty($mppluginSetting->get_setting('verification_mail_subject')) ? $mppluginSetting->get_setting('verification_mail_subject') : 'Email Verification'; ?>" placeholder="Email Subject">
                </div>
                <div class="my-2">
                    <textarea rows="4" name="<?= $mppluginSetting->get_field_name('verification_mail_body'); ?>" class="w-full" style="max-width:100%; width:100%; min-height:200px;" placeholder="Email Text"><?= !empty($mppluginSetting->get_setting('verification_mail_body')) ? $mppluginSetting->get_setting('verification_mail_body') : $verify_email; ?></textarea>
                </div>
                <?= get_test_email_template('verification'); ?>
             </div>


             <!-- Forget Password -->
             <div class="my-8 hidden" style="max-width:400px;width:100%;" data-target="forgot_pass">
                <div class="my-2">
                    <h2 class="text-2xl">Forgot Password</h2>
                </div>
                <div class="my-2">
                    <input type="text" name="<?= $mppluginSetting->get_field_name('forgot_pass_mail_subject'); ?>" class="w-full" style="max-width:100%; width:100%;" value="<?= !empty($mppluginSetting->get_setting('forgot_pass_mail_subject')) ? $mppluginSetting->get_setting('forgot_pass_mail_subject') : 'Email Verification'; ?>" placeholder="Email Subject">
                </div>
                <div class="my-2">
                    <textarea rows="4" name="<?= $mppluginSetting->get_field_name('forgot_pass_mail_body'); ?>" class="w-full" style="max-width:100%; width:100%; min-height:200px;" placeholder="Email Text"><?= !empty($mppluginSetting->get_setting('forgot_pass_mail_body')) ? $mppluginSetting->get_setting('forgot_pass_mail_body') : $forgot_email; ?></textarea>
                </div>
                <?= get_test_email_template('forgot_pass'); ?>
             </div>
        </div>
    </div>

        <input class="button-primary save-setting-btn" type="submit" value="Save Settings" />
	</form>
</div>

<script>

    class VToast{constructor(t){this.defaultOption={duration:2e3,delay:0},this.toastBottom=0,this.defaultStyle="transition:all ease 0.4s; padding:10px; border-radius:4px; position:fixed; z-index:999; box-shadow:0 1px 10px #ddd;",this.options=Object.assign(this.defaultOption,t)}success(t,o){this.showToast("success",t,o)}error(t,o){this.showToast("error",t,o)}info(t,o){this.showToast("info",t,o)}warning(t,o){this.showToast("warning",t,o)}randomId(){let t="",o="abcdefghijklmnopqrstuvwxyz",s=o.length;for(let i=0;i<5;i++)t+=o.charAt(Math.floor(Math.random()*s));return t}caculateToastsHeight(){let t=document.querySelectorAll(".v-toast"),o=0;t.forEach(t=>{o+=t.offsetHeight+20}),this.toastBottom=`bottom:${o+20}px`}getToastColor(t){return({success:{color:"#fff",background:"#17bc6d"},error:{color:"#fff",background:"#e94f75"},warning:{color:"#232323",background:"#ffe16c"},info:{color:"#232323",background:"#b7c1ff;"}})[t]}showToast(t,o,s=null){s&&(this.options=Object.assign(this.defaultOption,s)),this.msg=o,this.toastColor=this.getToastColor(t),this.caculateToastsHeight(),this.initToast()}initToast(){this.showStyle=`${this.defaultStyle} ${this.toastBottom}; right:10px; color:${this.toastColor.color}; background:${this.toastColor.background};`,this.hideStyle=`${this.defaultStyle} bottom:-200px; right:10px; color:${this.toastColor.color}; background:${this.toastColor.background};`;let t=document.createElement("div"),o=this.randomId();t.id=o,t.className="v-toast",t.setAttribute("style",this.hideStyle),t.innerText=this.msg,document.body.append(t);let s=document.querySelector(`#${o}`);setTimeout(()=>{s.setAttribute("style",this.showStyle)},this.options.delay),setTimeout(()=>{s.setAttribute("style",this.hideStyle)},this.options.duration),setTimeout(()=>{s.remove()},this.options.duration+100)}}

    jQuery(function($){

        const vtoast = new VToast();

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
            $('div[data-target]').addClass('hidden');
            if(target === 'Select'){
                return;
            }
            $(`div[data-target='${target}']`).removeClass('hidden');
        })


        // Send test
        $('.send-test').on('click', function(e){
            e.preventDefault();

            $test_email =  $(this).closest('.test-email').find('input');
           
            if(!$test_email.val()){
                vtoast.error('Please add test email.')
                return;
            }

            const data = {
                'action': 'test_email',
                'email': $test_email.val(),
                'template': $test_email.data('template')
            };

            $.ajax({
                type: 'POST',
                url: '/wp-admin/admin-ajax.php',
                data: data,
                success: function (response) {
                    if (!response.success) {
                        vtoast.error('Failed to send test email.')
                        return;
                    }
                    vtoast.success('Successfully sent test email.')
                }
            });
        })


    })
    
</script>