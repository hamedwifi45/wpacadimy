<?php

/**
 * academy widget
**/

// تعريف صنف الودجت الخاص بالأكاديمية
class Wpacademy_Widegt extends WP_Widget {

    // المُنشئ الرئيسي للودجت (يُستخدم لتسجيل الإعدادات الأساسية)
    public function __construct() {
        $widget_ops = array(
            'classname'    => 'wpacademy_widget', // اسم الصنف المُستخدم في HTML
            'description'  => __('This Widget displays the social icons', 'wpacademy'), // وصف الودجت في لوحة التحكم
            'customize_selective_refresh'  => true, // يتيح التحديث الجزئي عند التخصيص في المظهر
        );
        // استدعاء المُنشئ الأساسي لفئة WP_Widget لتسجيل الودجت مع الاسم والمعرف والإعدادات
        parent::__construct(
            'wpacademy_widget', // المعرف الفريد للودجت
            __('&raquo; Academy Social Icons', 'wpacademy'), // اسم الودجت الظاهر للمستخدم في لوحة التحكم
            $widget_ops // خيارات وإعدادات الودجت
        );
    }

    // إنشاء نموذج الإعدادات داخل لوحة التحكم
    public function form($instance) {
        // إعداد الحقول الافتراضية التي يمكن للمستخدم تعبئتها من لوحة التحكم
        $fields = array(
            'title' => __('Widget Title', 'wpacademy'), // عنوان الودجت
            'facebook' => __('Facebook', 'wpacademy'), // رابط فيسبوك
            'twitter' => __('Twitter', 'wpacademy'), // رابط تويتر
            'instagram' => __('Instagram', 'wpacademy'), // رابط انستغرام
            'linkedin' => __('LinkedIn', 'wpacademy') // رابط لينكد إن
        );

        // عرض الحقول للمستخدم مع إمكانية التعديل عليها
        foreach($fields as $field => $label) { ?>
            <p>
                <label for="<?php echo $this->get_field_id($field);?>">
                    <?php echo $label; ?>
                </label>
                <input class="widefat" 
                id="<?php echo $this->get_field_id($field);?>" 
                name="<?php echo $this->get_field_name($field);?>"
                type="text"
                value="<?php echo esc_attr($instance[$field]);?>" />
            </p>
        <?php
        }
    }

    // عند حفظ التعديلات على إعدادات الودجت
    public function update($new_instance, $old_instance) {
        $instance = $old_instance; // الحفاظ على البيانات السابقة
        foreach ($new_instance as $key => $value) {
            $instance[$key] = wp_strip_all_tags($value); // إزالة جميع الوسوم للحماية
        }
        return $instance; // إرجاع البيانات الجديدة
    }

    // عرض محتوى الودجت في الموقع
    public function widget($args, $instance) {
        extract($args); // استخراج متغيرات مثل before_widget و after_widget
        echo $before_widget; // طباعة بداية تنسيق الودجت

        // عرض العنوان إذا كان موجوداً
        if (!empty($instance['title'])) {
            echo $before_title . apply_filters('widget_title', $instance['title']) . $after_title;
        }

        // بداية صندوق الأيقونات
        echo '<div class="social-icons">';

        // مصفوفة الشبكات الاجتماعية مع الأيقونات الخاصة بها من FontAwesome
        $social_networks = array(
            'facebook' => 'fa-facebook-f',
            'twitter' => 'fa-x-twitter',
            'instagram' => 'fa-instagram',
            'linkedin' => 'fa-linkedin'
        );

        // عرض الروابط إذا كانت مدخلة من قبل المستخدم
        foreach($social_networks as $network => $icon) {
            if(!empty($instance[$network])){
                echo '<a class="' . $network . '" href="' . esc_url($instance[$network]) . '"><i class="fa-brands ' . $icon . '"></i></a>';
            }
        }

        echo '</div>'; // نهاية صندوق الأيقونات
        echo $after_widget; // طباعة نهاية تنسيق الودجت
    }
}

// تسجيل الودجت في ووردبريس
function register_wpacademy_widget() {
    register_widget('Wpacademy_Widegt'); // ربط الصنف بوظيفة الودجت
}

// تنفيذ وظيفة التسجيل عند تحميل الودجتات
add_action('widgets_init', 'register_wpacademy_widget');
