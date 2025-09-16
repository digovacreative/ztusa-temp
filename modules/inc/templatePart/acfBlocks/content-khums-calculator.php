<?php
/**
 * Block Name: Khums Calculator
 */
global $post;
global $location_block;
?>

<div class="gutenberg__wrap" <?php if(get_field('anchor_id')): echo 'id="'.get_field('anchor_id').'"'; endif; ?>>
   
    <section class="khums_calculator medium_box">

        <?php if(get_field('heading')): ?><h2><?php the_field('heading'); ?></h2><?php endif; ?>
        <script>
            jQuery(document).ready(function(){

                jQuery(document.body).on('blur', '.calc', function() {
                    var result = 0;
                    jQuery('.calc').each(function() {
                        var $input = jQuery(this),
                            value = parseFloat($input.val());
                        if (isNaN(value)) {
                            return;
                        }
                        var action = $input.data('action') == 'add' ? 1 : -1;
                        result += value * action;
                    });
                    
                    var khums = result / 5;
                    var half = khums / 2;

                    jQuery('#total').text(result.toFixed(2));
                    jQuery('#khums').text(khums.toFixed(2));
                    jQuery('#half1').text(half.toFixed(2));
                    jQuery('#half2').text(half.toFixed(2));

                    jQuery('.payyourprice_contribution').val(khums.toFixed(2));
                });
            });
        </script>



        <form class="khums aos-item" data-aos="fade-up">
            
            <div class="calculator">
                <p class="half_field amount_field">
                    <label>Savings end of the year</label>
                    <span class="currency"><?= get_woocommerce_currency_symbol() ?></span>
                    <input type="number" name="txt" class="calc" data-action="add" placeholder="0" />
                </p>
                <p class="half_field amount_field">
                    <label>Annual business profits &amp; assets</label>
                    <span class="currency"><?= get_woocommerce_currency_symbol() ?></span>
                    <input type="number" name="txt" class="calc" data-action="add" placeholder="0" />
                </p>

                <p class="half_field amount_field">
                    <label>Unused gifts (in a full year)</label>
                    <span class="currency"><?= get_woocommerce_currency_symbol() ?></span>
                    <input type="number" name="txt" class="calc" data-action="add" placeholder="0" />
                </p>
                <p class="half_field amount_field">
                    <label>Unused items (in a full year)</label>
                    <span class="currency"><?= get_woocommerce_currency_symbol() ?></span>
                    <input type="number" name="txt" class="calc" data-action="add" placeholder="0" />
                </p>
                
                <p class="clear amount_field">
                    <label>Any other income</label>
                    <span class="currency"><?= get_woocommerce_currency_symbol() ?></span>
                    <input type="number" name="txt" class="calc" data-action="add" placeholder="0" />
                </p>
                
                <p class="amount_field">
                    <label>Remainder on last years savings on which khums was already paid</label>
                    <span class="currency"><?= get_woocommerce_currency_symbol() ?></span>
                    <input type="number" name="minus" class="calc" data-action="sub" placeholder="0" />
                </p>
                
                <p class="totalField">
                    <label>Total profit</label>
                    <span id="total">0</span>
                </p>
            </div>

            <div class="calculation">
                <h3>KHUMS CALCULATION</h3>

                <div class="totalbox">
                <p>
                    <label>Total Khums</label>
                    <span id="khums">0</span>
                </p>

                <p>
                    <label>Sehme Imam (AJF)</label>
                    <span id="half1">0</span>
                </p>

                <p>
                    <label>Sehme Sadat</label>
                    <span id="half2">0</span>
                </p>
                </div>

                
                <div class="khums_project_donate">
                    <div id="khums_donation"></div>
                    <?php $khums_project = get_field('khums_project_feed'); ?>
                    <script>
                    function load_the_project_quickdonate($project_id){
                        console.log($project_id);
                        jQuery.ajax({
                            url:  $ajaxurl,
                            data: 'action=loadproject&project_id='+$project_id,
                            type: 'POST',
                            beforeSend:function(xhr){
                                // ajax_before();
                            },
                            success:function(data){
                                // ajax_after();
                                jQuery('#khums_donation').addClass('active');
                                jQuery('#khums_donation').html(data);
                            }

                        });
                        return false;
                    }

                    load_the_project_quickdonate(<?php echo $khums_project; ?>);
                    </script>
                    
                </div>
                <svg id="Layer_1" class="khums_icon" style="enable-background:new 0 0 100 100;" version="1.1" viewBox="0 0 100 100" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M35.12,81.68c4.47,0,8.68-1.74,11.84-4.91l5.47-5.47c0,0,0,0,0,0l8.29-8.29c0.41-0.41,0.73-0.9,0.96-1.42  c0.31-0.04,0.62-0.16,0.86-0.4l4.91-4.91l3.38-3.38l5.47-5.47c6.53-6.53,6.53-17.15,0-23.68c-6.53-6.53-17.16-6.53-23.68,0  l-1.97,1.97l-6.88,6.88l-3.12,3.12c-0.65,0.65-1.01,1.52-1.01,2.44s0.36,1.79,1.06,2.48c0.65,0.65,1.44,1.1,2.3,1.36l-0.73,0.73  l-0.73,0.73c-0.27-0.86-0.72-1.67-1.41-2.35c-1.3-1.3-3.57-1.3-4.87,0l-3.12,3.12c0,0,0,0,0,0l-8.85,8.85  c-6.53,6.53-6.53,17.15,0,23.68C26.44,79.94,30.65,81.68,35.12,81.68z M42.64,38.16c0-0.08,0.02-0.21,0.13-0.32l10-10l1.97-1.97  c5.36-5.36,14.08-5.36,19.44,0c2.6,2.6,4.03,6.05,4.03,9.72s-1.43,7.12-4.03,9.72l-5.47,5.47l-3.38,3.38l-3.71,3.71  c-0.22-0.47-0.51-0.92-0.89-1.3c-0.38-0.38-0.82-0.67-1.3-0.89l7.09-7.09c0.29-0.29,0.44-0.68,0.44-1.06c0-0.38-0.15-0.77-0.44-1.06  c-0.59-0.59-1.54-0.59-2.12,0l-3.7,3.7c-0.22-0.47-0.5-0.91-0.89-1.3c-0.38-0.38-0.82-0.67-1.3-0.89l3.7-3.7  c0.29-0.29,0.44-0.68,0.44-1.06c0-0.38-0.15-0.77-0.44-1.06c-0.59-0.59-1.54-0.59-2.12,0l-0.85,0.85c-0.22-0.47-0.51-0.92-0.89-1.3  c-0.38-0.38-0.82-0.67-1.3-0.89l0.85-0.85c0.29-0.29,0.44-0.68,0.44-1.06c0-0.38-0.15-0.77-0.44-1.06c-0.59-0.59-1.54-0.59-2.12,0  l-3.7,3.7c-0.22-0.47-0.5-0.91-0.89-1.3c-0.38-0.38-0.82-0.67-1.3-0.89l3.7-3.7c0,0,0,0,0,0l2.53-2.53  c1.59,1.15,3.48,1.78,5.48,1.78c2.51,0,4.86-0.98,6.63-2.75c0.59-0.59,0.59-1.54,0-2.12c-0.59-0.59-1.54-0.59-2.12,0  c-1.21,1.21-2.81,1.87-4.51,1.87s-3.31-0.66-4.51-1.87c-0.59-0.59-1.54-0.59-2.12,0l-8.49,8.49c-0.98,0.98-2.63,1.02-3.71-0.05  C42.66,38.36,42.64,38.24,42.64,38.16z M25.4,55.21l1.97-1.97l10-10c0.11-0.11,0.23-0.13,0.32-0.13s0.21,0.02,0.36,0.18  c0.49,0.49,0.76,1.14,0.76,1.83c0,0.69-0.27,1.34-0.76,1.83l-8.49,8.49c-0.59,0.59-0.59,1.54,0,2.12c0.29,0.29,0.68,0.44,1.06,0.44  s0.77-0.15,1.06-0.44l3.5-3.5c0,0,0,0,0,0l11.68-11.68c0.6-0.6,1.59-0.6,2.19,0c0.6,0.6,0.6,1.59,0,2.19l-7.82,7.82c0,0,0,0,0,0  l-3.87,3.87c-0.29,0.29-0.44,0.68-0.44,1.06c0,0.38,0.15,0.77,0.44,1.06c0.29,0.29,0.68,0.44,1.06,0.44s0.77-0.15,1.06-0.44  l11.68-11.68c0,0,0,0,0,0l2.84-2.84c0.59-0.59,1.61-0.59,2.19,0c0.29,0.29,0.45,0.68,0.45,1.1c0,0.41-0.16,0.8-0.45,1.1L41.69,60.55  c-0.29,0.29-0.44,0.68-0.44,1.06c0,0.38,0.15,0.77,0.44,1.06c0.29,0.29,0.68,0.44,1.06,0.44s0.77-0.15,1.06-0.44l3.87-3.87  c0,0,0,0,0,0l7.82-7.82c0.59-0.58,1.61-0.58,2.19,0c0.6,0.6,0.6,1.59,0,2.19l-3.4,3.4c0,0,0,0,0,0L46,64.87  c-0.29,0.29-0.44,0.68-0.44,1.06c0,0.38,0.15,0.77,0.44,1.06c0.29,0.29,0.68,0.44,1.06,0.44s0.77-0.15,1.06-0.44l8.29-8.29  c0.59-0.59,1.61-0.59,2.19,0c0.29,0.29,0.45,0.68,0.45,1.1s-0.16,0.8-0.45,1.1L53.7,65.8c0,0,0,0,0,0l-8.85,8.85  c-2.6,2.6-6.05,4.03-9.72,4.03S28,77.25,25.4,74.65C20.04,69.29,20.04,60.57,25.4,55.21z"/></svg>
            </div>

        </form>

    </section>

</div>
