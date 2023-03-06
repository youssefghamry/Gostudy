<?php
/*
 * This template can be overridden by copying it to yourtheme/gostudy-core/elementor/widgets/rt-accordion-service.php.
*/
namespace RTAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{Widget_Base, Controls_Manager, Control_Media, Repeater, Core\Schemes\Typography as Typography};
use Elementor\{Utils, Group_Control_Typography, Group_Control_Image_Size, Icons_Manager, Group_Control_Border, Group_Control_Background};
use RTAddons\Gostudy_Global_Variables as Gostudy_Globals;
use RTAddons\Includes\RT_Icons;

class RT_Accordion_Service extends Widget_Base
{
    public function get_name()
    {
        return 'rt-accordion-service';
    }

    public function get_title()
    {
        return esc_html__('Accordion Service', 'gostudy-core');
    }

    public function get_icon()
    {
        return 'rt-accordion-services';
    }

    public function get_categories()
    {
        return ['rt-extensions'];
    }

    protected function register_controls()
    {
        /**
         * CONTENT -> GENERAL
         */

        $this->start_controls_section(
            'section_content_general',
            ['label' => esc_html__('General', 'gostudy-core')]
        );

        $this->add_control(
            'item_col',
            [
                'label' => esc_html__('Grid Columns Amount', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '2' => esc_html__('2 / Two', 'gostudy-core'),
                    '3' => esc_html__('3 / Three', 'gostudy-core'),
                    '4' => esc_html__('4 / Four', 'gostudy-core'),
                ],
                'default' => '4',
                'prefix_class' => 'grid-col-'
            ]
        );

        $this->add_responsive_control(
            'item_min_height',
            [
                'label' => esc_html__('Items Min Height', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 200, 'max' => 1000],
                ],
                'default' => ['size' => 280],
                'selectors' => [
                    '{{WRAPPER}} .service__item' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> ITEMS
         */

        $this->start_controls_section(
            'section_content_items',
            ['label' => esc_html__('Items', 'gostudy-core')]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'bg_color',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .service__thumbnail' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $repeater->add_control(
            'thumbnail',
            [
                'label' => esc_html__('Thumbnail', 'gostudy-core'),
                'type' => Controls_Manager::MEDIA,
                'label_block' => true,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .service__thumbnail' => 'background-image: url({{URL}});',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'bg_position',
            [
                'label' => esc_html__('Position', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['thumbnail[url]!' => ''],
                'options' => [
                    'center center' => esc_html__('Center Center', 'gostudy-core'),
                    'center left' => esc_html__('Center Left', 'gostudy-core'),
                    'center right' => esc_html__('Center Right', 'gostudy-core'),
                    'top center' => esc_html__('Top Center', 'gostudy-core'),
                    'top left' => esc_html__('Top Left', 'gostudy-core'),
                    'top right' => esc_html__('Top Right', 'gostudy-core'),
                    'bottom center' => esc_html__('Bottom Center', 'gostudy-core'),
                    'bottom left' => esc_html__('Bottom Left', 'gostudy-core'),
                    'bottom right' => esc_html__('Bottom Right', 'gostudy-core'),
                ],
                'default' => 'center center',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .service__thumbnail' => 'background-position: {{VALUE}};',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'bg_repeat',
            [
                'label' => esc_html__('Repeat', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['thumbnail[url]!' => ''],
                'options' => [
                    'no-repeat' => esc_html__('No-repeat', 'gostudy-core'),
                    'repeat' => esc_html__('Repeat', 'gostudy-core'),
                    'repeat-x' => esc_html__('Repeat X', 'gostudy-core'),
                    'repeat-y' => esc_html__('Repeat Y', 'gostudy-core'),
                ],
                'default' => 'no-repeat',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .service__thumbnail' => 'background-repeat: {{VALUE}};',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'bg_size',
            [
                'label' => esc_html__('Size', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['thumbnail[url]!' => ''],
                'options' => [
                    'cover' => esc_html__('Cover', 'gostudy-core'),
                    'contain' => esc_html__('Contain', 'gostudy-core'),
                    'auto' => esc_html__('Auto', 'gostudy-core'),
                ],
                'default' => 'cover',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .service__thumbnail' => 'background-size: {{VALUE}};',
                ],
            ]
        );

        $repeater->add_control(
            'item_title',
            [
                'label' => esc_html__('Title', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'separator' => 'before',
                'label_block' => true,
                'dynamic' => ['active' => true],
            ]
        );

        $repeater->add_control(
            'item_content',
            [
                'label' => esc_html__('Content', 'gostudy-core'),
                'type' => Controls_Manager::TEXTAREA,
                'dynamic' => ['active' => true],
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'gostudy-core'),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'dynamic' => ['active' => true],
            ]
        );

        $repeater->add_control(
            'content_media_type',
            [
                'label' => esc_html__('Media Type', 'gostudy-core'),
                'type' => Controls_Manager::CHOOSE,
                'separator' => 'before',
                'label_block' => false,
                'toggle' => false,
                'options' => [
                    '' => [
                        'title' => esc_html__('None', 'gostudy-core'),
                        'icon' => 'fa fa-ban',
                    ],
                    'font' => [
                        'title' => esc_html__('Icon', 'gostudy-core'),
                        'icon' => 'fa fa-smile-o',
                    ],
                    'image' => [
                        'title' => esc_html__('Image', 'gostudy-core'),
                        'icon' => 'fa fa-picture-o',
                    ]
                ],
                'default' => '',
            ]
        );

        $repeater->add_control(
            'content_icon',
            [
                'label' => esc_html__('Icon', 'gostudy-core'),
                'type' => Controls_Manager::ICONS,
                'condition' => ['content_media_type' => 'font'],
                'label_block' => true,
                'description' => esc_html__('Select icon from available libraries.', 'gostudy-core'),
            ]
        );

        $repeater->add_control(
            'content_thumbnail',
            [
                'label' => esc_html__('Image', 'gostudy-core'),
                'type' => Controls_Manager::MEDIA,
                'condition' => ['content_media_type' => 'image'],
                'label_block' => true,
                'default' => ['url' => Utils::get_placeholder_image_src()],
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => esc_html__('Items', 'gostudy-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{item_title}}',
                'default' => [
                    ['item_title' => esc_html__('Title 1', 'gostudy-core')],
                    ['item_title' => esc_html__('Title 2', 'gostudy-core')],
                    ['item_title' => esc_html__('Title 3', 'gostudy-core')],
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> LINK
         */

        $this->start_controls_section(
            'section_content_link',
            ['label' => esc_html__('Link', 'gostudy-core')]
        );

        $this->add_control(
            'thumbnail_link',
            [
                'label' => esc_html__('Thumbnail Clickable', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'read_more_link',
            [
                'label' => esc_html__('Add \'Read More\' Button', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label' => esc_html__('Button Text', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'default' => esc_html__('Read More', 'gostudy-core'),
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> ITEM
         */

        $this->start_controls_section(
            'section_style_item',
            [
                'label' => esc_html__('Item', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'item_radius',
            [
                'label' => esc_html__('Item Border Radius', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => 5,
                    'left' => 5,
                    'right' => 5,
                    'bottom' => 5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .service__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'content_heading',
            [
                'label' => esc_html__('Content', 'gostudy-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 30,
                    'left' => 30,
                    'right' => 30,
                    'bottom' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .service__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'content_bg',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => '#f8f4ef',
                'selectors' => [
                    '{{WRAPPER}} .service__content' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> ICON
         */

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Icon', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'icon_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 0,
                    'left' => 0,
                    'right' => 0,
                    'bottom' => 17,
                ],
                'selectors' => [
                    '{{WRAPPER}} .content__media.icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .content__media.icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .content__media.icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 10, 'max' => 100],
                ],
                'default' => ['size' => 50],
                'selectors' => [
                    '{{WRAPPER}} .content__media.icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> TITLE
         */

        $this->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__('Title', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title',
                'selector' => '{{WRAPPER}} .content__title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => ['default' => ['size' => 22]],
                    'font_weight' => ['default' => 600],
                    'line_height' => ['default' => ['size' => 1]],
                ],
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label' => esc_html__('HTML Tag', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => '‹h1›',
                    'h2' => '‹h2›',
                    'h3' => '‹h3›',
                    'h4' => '‹h4›',
                    'h5' => '‹h5›',
                    'h6' => '‹h6›',
                    'div' => '‹div›',
                    'span' => '‹span›',
                ],
                'default' => 'h3',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 0,
                    'left' => 0,
                    'right' => 0,
                    'bottom' => 22,
                ],
                'selectors' => [
                    '{{WRAPPER}} .content__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'default' => Gostudy_Globals::get_h_font_color(),
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .content__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> DESCRIPTION
         */

        $this->start_controls_section(
            'section_style_description',
            [
                'label' => esc_html__('Description', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description',
                'selector' => '{{WRAPPER}} .content__description',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => ['default' => ['size' => 14]],
                ],
            ]
        );

        $this->add_control(
            'description_tag',
            [
                'label' => esc_html__('HTML Tag', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'div',
                'options' => [
                    'h1' => '‹h1›',
                    'h2' => '‹h2›',
                    'h3' => '‹h3›',
                    'h4' => '‹h4›',
                    'h5' => '‹h5›',
                    'h6' => '‹h6›',
                    'div' => '‹div›',
                    'span' => '‹span›',
                ],
            ]
        );

        $this->add_responsive_control(
            'description_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .content__description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'default' => Gostudy_Globals::get_main_font_color(),
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .content__description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> BUTTON
         */

        $this->start_controls_section(
            'section_style_button',
            [
                'label' => esc_html__('Button', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['read_more_text!' => ''],
            ]
        );

        $this->add_responsive_control(
            'button_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 18,
                    'left' => 0,
                    'right' => 0,
                    'bottom' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .content__button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 10,
                    'left' => 20,
                    'right' => 20,
                    'bottom' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .content__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_radius',
            [
                'label' => esc_html__('Border Radius', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => 5,
                    'left' => 5,
                    'right' => 5,
                    'bottom' => 5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .content__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'button',
            ['separator' => 'before']
        );

        $this->start_controls_tab(
            'custom_button_color_idle',
            ['label' => esc_html__('Idle', 'gostudy-core')]
        );

        $this->add_control(
            'button_color_idle',
            [
                'label' => esc_html__('Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .content__button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_idle',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_secondary_color(),
                'selectors' => [
                    '{{WRAPPER}} .content__button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_idle',
                'selector' => '{{WRAPPER}} .content__button',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_button_color_hover',
            ['label' => esc_html__('Hover', 'gostudy-core')]
        );

        $this->add_control(
            'button_color_hover',
            [
                'label' => esc_html__('Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .content__button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_hover',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .content__button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_hover',
                'selector' => '{{WRAPPER}} .content__button:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    public function render()
    {
        $_s = $this->get_settings_for_display();

        $this->add_render_attribute('services', 'class', 'rt-accordion-services');

        $kses_allowed_html = [
            'a' => [
                'href' => true, 'title' => true,
                'class' => true, 'style' => true,
                'rel' => true, 'target' => true
            ],
            'br' => ['class' => true, 'style' => true],
            'em' => ['class' => true, 'style' => true],
            'strong' => ['class' => true, 'style' => true],
            'span' => ['class' => true, 'style' => true],
            'p' => ['class' => true, 'style' => true],
            'small' => ['class' => true, 'style' => true]
        ];

        echo '<div ', $this->get_render_attribute_string('services'), '>';

            foreach ($_s['items'] as $index => $item) {
                $has_link = !empty($item['link']['url']);

                if ($has_link) {
                    $link = $this->get_repeater_setting_key('link', 'items', $index);
                    $this->add_link_attributes($link, $item['link']);
                }

                echo '<div class="service__item elementor-repeater-item-', $item['_id'], '">';

                    // Thumbnail
                    printf(
                        '<%1$s class="service__thumbnail"></%1$s>',
                        !empty($_s['thumbnail_link']) && $has_link
                            ? 'a ' . $this->get_render_attribute_string($link)
                            : 'div'
                    );

                    echo '<div class="service__content">';

                    // ↓ Icon|Image
                    if ($item['content_media_type'] != '') {
                        if (
                            $item['content_media_type'] == 'font'
                            && !empty($item['content_icon'])
                        ) {
                            $media_class = ' icon';
                            $migrated = isset($item['__fa4_migrated'][$item['content_icon']]);
                            $is_new = Icons_Manager::is_migration_allowed();
                            if ($is_new || $migrated) {
                                ob_start();
                                Icons_Manager::render_icon($item['content_icon']);
                                $media_html = ob_get_clean();
                            } else {
                                $media_html = '<i class="icon ' . esc_attr($item['content_icon']) . '"></i>';
                            }
                        }

                        if (
                            $item['content_media_type'] == 'image'
                            && !empty($item['content_thumbnail']['url'])
                        ) {
                            $media_class = ' image';

                            $this->add_render_attribute('thumbnail', 'src', $item['content_thumbnail']['url']);
                            $this->add_render_attribute('thumbnail', 'alt', Control_Media::get_image_alt($item['content_thumbnail']));
                            $this->add_render_attribute('thumbnail', 'title', Control_Media::get_image_title($item['content_thumbnail']));

                            $media_html = Group_Control_Image_Size::get_attachment_image_html($item, 'thumbnail', 'content_thumbnail');
                        }

                        echo '<span class="content__media', $media_class ?? '', '">',
                            $media_html ?? '',
                        '</span>';
                    }
                    // ↑ icon|image

                    // Title
                    if (!empty($item['item_title'])) {
                        echo '<', $_s['title_tag'], ' class="content__title">',
                            wp_kses($item['item_title'], $kses_allowed_html),
                            '</', $_s['title_tag'], '>';
                    }

                    // Description
                    if (!empty($item['item_content'])) {
                        echo '<', $_s['description_tag'], ' class="content__description">',
                            wp_kses($item['item_content'], $kses_allowed_html),
                            '</', $_s['description_tag'], '>';
                    }

                    // Read More
                    if (!empty($_s['read_more_link']) && $has_link) {
                        echo '<a ', $this->get_render_attribute_string($link), ' class="content__button" role="button">',
                            $_s['read_more_text'],
                        '</a>';
                    }

                    echo '</div>'; // service__content

                echo '</div>';
            }

        echo '</div>';
    }
}
