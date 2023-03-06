<?php
namespace RTAddons\Controls;

defined('ABSPATH') || exit;

use Elementor\Base_Data_Control;
use RTAddons\Includes\RT_Elementor_Helper;

/**
 * RT Elementor Custom Icon Control
 *
 *
 * @category Class
 * @package gostudy-core\includes\elementor
 * @author RaisTheme <help.raistheme@gmail.com>
 * @since 1.0.0
 */
class RT_Icon extends Base_Data_Control
{
    /**
     * Get radio image control type.
     *
     * Retrieve the control type, in this case `radio-image`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type() {
        return 'rt-icon';
    }

    public function enqueue() {
        // Scripts
        wp_enqueue_script( 'rt-elementor-extensions', RT_ELEMENTOR_ADDONS_URL . 'assets/js/rt_elementor_extenstions.js');

        // Style
        wp_enqueue_style( 'rt-elementor-extensions', RT_ELEMENTOR_ADDONS_URL . 'assets/css/rt_elementor_extenstions.css');
    }

    public static function get_flaticons() {
        $array = RT_Elementor_Helper::get_instance()->get_rt_icons();
        
        $new_array = [];
        foreach ($array as $key => $value) {
            $new_array['flaticon-'.$value] = $value;
        }

        return $new_array;
    }

    /**
     * Get radio image control default settings.
     *
     *
     * @since 1.0.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings() {
        return [
            'label_block' => true,
            'options' => self::get_flaticons(),
            'include' => '',
            'exclude' => '',
            'select2options' => [],
        ];
    }

    /**
     * Render radio image control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template() {

        $control_uid = $this->get_control_uid();
        ?>
        <div class="elementor-control-field">
            <# if ( data.label ) {#>
                <label for="<?php echo $control_uid; ?>" class="elementor-control-title">{{{ data.label }}}</label>
            <# } #>
            <div class="elementor-control-input-wrapper">
                <select id="<?php echo $control_uid; ?>" class="elementor-control-icon elementor-select2" type="select2"  data-setting="{{ data.name }}" data-placeholder="<?php echo __( 'Select Icon', 'gostudy-core' ); ?>">
                    <# _.each( data.options, function( option_title, option_value ) {
                        var value = data.controlValue;
                        if ( typeof value == 'string' ) {
                            var selected = ( option_value === value ) ? 'selected' : '';
                        } else if ( null !== value ) {
                            var value = _.values( value );
                            var selected = ( -1 !== value.indexOf( option_value ) ) ? 'selected' : '';
                        }
                        #>
                    <option {{ selected }} value="{{ option_value }}">{{{ option_title }}}</option>
                    <# } ); #>
                </select>
            </div>
        </div>
        <# if ( data.description ) { #>
            <div class="elementor-control-field-description">{{{ data.description }}}</div>
        <# } #>
        <?php
    }
}
