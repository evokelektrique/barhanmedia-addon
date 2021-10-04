<div class="wrap">
    <h1><?php _e( 'افزودن فصل', 'barhanmedia' ); ?></h1>

    <form action="" method="post">

        <table class="form-table">
            <tbody>
                <tr class="row-page-address">
                    <th scope="row">
                        <label for="title"><?php _e( 'عنوان فصل', 'barhanmedia' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="title" id="title" class="regular-text" placeholder="<?php echo esc_attr( '', 'barhanmedia' ); ?>" value="" />
                    </td>
                </tr>
             </tbody>
        </table>

        <input type="hidden" name="field_id" value="0">

        <?php wp_nonce_field( '' ); ?>
        <?php submit_button( __( 'ثبت', 'barhanmedia' ), 'primary', 'submit_season' ); ?>

    </form>
</div>