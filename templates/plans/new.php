<div class="wrap">
    <h1><?php _e( 'افزودن پلن', 'barhanmedia' ); ?></h1>

    <form action="" method="post">

        <table class="form-table">
            <tbody>
                <tr class="row">
                    <th scope="row">
                        <label for="name"><?php _e( 'اسم', 'barhanmedia' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="name" id="name" class="regular-text" placeholder="<?php echo esc_attr( '', 'barhanmedia' ); ?>" value="" />
                        <span class="description"><?php _e('توضیحات یا اسم پلن مورد نظر را در این فیلد بنویسید', 'barhanmedia' ); ?></span>
                    </td>
                </tr>
                <tr class="row">
                    <th scope="row">
                        <label for="amount"><?php _e( 'مقدار', 'barhanmedia' ); ?></label>
                    </th>
                    <td>
                        <input type="number" name="amount" id="amount" class="regular-text" placeholder="<?php echo esc_attr( '', 'barhanmedia' ); ?>" value="" />
                        <span class="description"><?php _e('حداکثر تعداد مورد نظر', 'barhanmedia' ); ?></span>
                    </td>
                </tr>
                <tr class="row">
                    <th scope="row">
                        <label for="price"><?php _e( 'قیمت', 'barhanmedia' ); ?></label>
                    </th>
                    <td>
                        <input type="number" name="price" id="price" class="regular-text" placeholder="<?php echo esc_attr( '', 'barhanmedia' ); ?>" value="" />
                        <span class="description"><?php _e('قیمت مورد نظر پلن را وارد کنید <b>(فقط عدد)</b>', 'barhanmedia' ); ?></span>
                    </td>
                </tr>
                <tr class="row">
                    <th scope="row">
                        <label for="type"><?php _e( 'نوع', 'barhanmedia' ); ?></label>
                    </th>
                    <td>
                        <select name="type" id="type">
                            <option value="like">لایک</option>
                            <option value="comment">کامنت</option>
                            <option value="follower">فالوور</option>
                        </select>

                        <span class="description"><?php _e('نوع پلن مورد نظر را انتخاب کنید', 'barhanmedia' ); ?></span>
                    </td>
                </tr>
             </tbody>
        </table>

        <input type="hidden" name="field_id" value="0">

        <?php wp_nonce_field( '' ); ?>
        <?php submit_button( __( 'ثبت', 'barhanmedia' ), 'primary', 'submit_plan' ); ?>

    </form>
</div>