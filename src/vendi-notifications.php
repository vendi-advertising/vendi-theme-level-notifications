<?php declare(strict_types=1);

/**
 * Register a page-level notice for display later.
 *
 * @param string $message            the message to display
 * @param string $type               one of success, warning, error, info
 * @param bool   $dismissable        If true, show an "x" that users can click to hide the notice. Default true.
 * @param bool   $enqueue_css_and_js If true, enqueue the CSS and JS required to show the notices. Default true.
 */
function vendi_notifications_register_notice($message, $type, $dismissable = true, $enqueue_css_and_js = true)
{
    if ($enqueue_css_and_js) {
        $t = VENDI_NOTIFICATIONS_PATH . '/css/notices.css';
        wp_enqueue_style(
                            basename($t, '.css') . '-style',
                            VENDI_NOTIFICATIONS_URL . '/css/' . basename($t),
                            null,
                            filemtime(VENDI_NOTIFICATIONS_PATH . '/css/' . basename($t)),
                            'screen'
                        );

        $t = VENDI_NOTIFICATIONS_PATH . '/css/notices.js';
        wp_enqueue_script(
                            basename($t, '.js') . '-style',
                            VENDI_NOTIFICATIONS_URL . '/js/' . basename($t),
                            false,
                            filemtime(VENDI_NOTIFICATIONS_PATH . '/js/' . basename($t)),
                            true
                        );
    }

    global $vendi_theme_notifications;

    if (! array_key_exists($type, $vendi_theme_notifications)) {
        $vendi_theme_notifications[ $type ] = [];
    }

    $vendi_theme_notifications[ $type ][] = [
                                                    'message' => $message,
                                                    'dismissable' => $dismissable,
                                            ];
}

function vendi_notifications_show_notices($echo = true, $reset = true)
{
    $buf = [];

    global $vendi_theme_notifications;
    foreach ($vendi_theme_notifications as $type => $notices) {
        foreach ($notices as $notice) {
            $buf[] = "<div class=\"notice notice-${type} no-print\">";
            $buf[] = "<p>${notice['message']}</p>";
            if (true === $notice[ 'dismissable' ]) {
                $buf[] = '<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>';
            }
            $buf[] = '</div>';
        }
    }

    $ret = implode('', $buf);

    if ($echo) {
        echo $ret;
    }

    if ($reset) {
        $vendi_theme_notifications = [];
    }

    return $ret;
}

function vendi_notifications_register_plugin_css($file, $media = 'all')
{
    wp_enqueue_style(
                        basename($file, '.css'),
                        plugins_url('/css/' . $file, VENDI_NOTIFICATIONS_FILE),
                        null,
                        filemtime(VENDI_NOTIFICATIONS_PATH . '/css/' . $file),
                        $media
                    );
}

function vendi_notifications_register_plugin_js($file, $footer = true)
{
    wp_enqueue_script(
                        basename($file, '.js'),
                        plugins_url('/js/' . $file, VENDI_NOTIFICATIONS_FILE),
                        false,
                        filemtime(VENDI_NOTIFICATIONS_PATH . '/js/' . $file),
                        $footer
                    );
}
