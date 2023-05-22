<div class="wrap">
    <h1><?php _e( 'Rao Miusage Data', 'raomi' );?></h1>
    <p class="desc"><?php _e( 'This page provides a preview of dat fetched from remote API which can be used in pages and post using Gutenberg block.', 'raomi' )?></p>
    <?php 
        $raomi_cached_data = get_transient( '_raomiusage_data' );
        $button_label = $raomi_cached_data ? __( 'Force Refresh', 'raomi' ) : __( 'Fetch Data', 'raomi' );
    ?>

    <div id="raomi_api_response"></div>
    <form id="raomi_api_form" method="post" action="<?php esc_url(menu_page_url('rao-miusage-data-refresh'));?>" novalidate="novalidate">
        <input type="hidden" name="action" value="raomi_fetch_data" />
        <input type="hidden" name="force_refresh" value="1" />
        <?php wp_nonce_field( 'raomi_fetch_data_nonce' );?>
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo esc_html($button_label);?>">
            <span class="spinner"></span>
        </p>
        <p class="desc"><?php printf( __( 'Force Refresh using WP CLI: %s', 'raomi' ), '<code>wp raomirefresh</code>');?></p>
    </form>

    <?php
    if( $raomi_cached_data ):
        printf( "<h3>" . __( 'Table name: %s', 'raomi' ) . "</h3>", esc_html($raomi_cached_data->title) );

        $headers = $raomi_cached_data->data->headers;
        $rows = $raomi_cached_data->data->rows;

        printf('<table class="wp-list-table widefat fixed striped table-view-list pages" >');
        
            printf("<thead><tr>");
                foreach( $headers as $column ){
                    printf( "<td>%s</td>", esc_html($column) );
                }
            printf("</tr><thead>");

            printf("<tbody>");

                $date_format = get_option('date_format');
                
                foreach( $rows as $row ){
                    printf('<tr>');
                        printf( "<td>%s</td>", esc_html($row->id) );
                        printf( "<td>%s</td>", esc_html($row->fname) );
                        printf( "<td>%s</td>", esc_html($row->lname) );
                        printf( "<td>%s</td>", esc_html($row->email) );
                        printf( "<td>%s</td>", date( $date_format, esc_html($row->date) ) );
                    printf('</tr>');
                }
            printf("<tbody>");
        printf('</table>');
    endif;
    ?>

</div>