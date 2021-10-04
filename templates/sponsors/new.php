<div class="wrap">
    <h1><?php _e( 'افزودن اسپانسر', 'barhanmedia' ); ?></h1>

    <form action="" method="post">

        <table class="form-table">
            <tbody>
                <tr class="row-page-address">
                    <th scope="row">
                        <label for="page_username"><?php _e( 'آدرس صفحه اینستاگرام', 'barhanmedia' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="page_username" id="page_username" class="regular-text" placeholder="<?php echo esc_attr( '', 'barhanmedia' ); ?>" value="" />
                        <span class="description"><?php _e('آدرس یا نام کاربری صفحه شامل instagram.com/<b>page_username</b> می باشد.', 'barhanmedia' ); ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="page_username"><?php _e( 'فصل', 'barhanmedia' ); ?></label>
                    </th>
                    <td>
                        <select name="season_id">

                            <?php 
                            $seasons = BarhanMediaSeasonsFunctions::get_all_season();
                            foreach($seasons as &$season):
                            ?>
                            <option value="<?= $season->id ?>"><?= $season->title ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
             </tbody>
        </table>

        <input type="hidden" name="field_id" value="0">

        <?php wp_nonce_field( '' ); ?>
        <?php submit_button( __( 'ثبت', 'barhanmedia' ), 'primary', 'submit_sponsor' ); ?>

    </form>
</div>