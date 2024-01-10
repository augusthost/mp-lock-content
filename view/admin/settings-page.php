<?php

if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}

global $mppluginSetting; // we'll need this below
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

</style>

<div class="wrapper">
    <h1 class="my-4"><?php esc_html_e('Plugin Settings', 'gmi'); ?></h1>

    <form method="post" id="theme-setting" action="<?= $_SERVER['REQUEST_URI']; ?>">
    <?php $mppluginSetting->the_nonce(); ?>

    <div class="tabs">
        <span class="tab">General</span>
        <span class="tab">Others</span>
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
                            <option value="<?= $category->term_id; ?>"  <?= $mppluginSetting->get_setting('locked_cat') == $category->term_id ? 'selected' : ''; ?> ><?= $category->name; ?></option>
                            <?php endforeach; ?>
                           </select>
						</label>
					</td>
			</tr>
            <tr>
				<th scope="row" valign="top">Disabled Message</th>
					<td>
						<label>
                            <input name="<?= $mppluginSetting->get_field_name('disabled_message'); ?>" value="<?= $mppluginSetting->get_setting('disabled_message'); ?>" id="" />
						</label>
					</td>
			</tr>
            </tbody>
            </table>
        </div>
        <div class="tab_item">
            <h1>Others</h1>
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

    })
    
</script>