<?php

namespace App\Support;

/** Field definitions that drive the generic admin CRUD screens. */
class AdminResources
{
    const RESERVED = ['admin', 'blog', 'blogs', 'about', 'contact', 'courses', 'universities', 'compare', 'sitemap', 'robots', 'assets', 'uploads', 'storage', 'up', 'login'];

    public static function seo(): array
    {
        return [
            ['meta_title', 'Meta title', 'text', 'help' => 'Recommended 50-60 characters', 'tab' => 'SEO'],
            ['meta_description', 'Meta description', 'textarea', 'rows' => 3, 'help' => 'Recommended 140-160 characters', 'tab' => 'SEO'],
            ['meta_keywords', 'Meta keywords', 'textarea', 'rows' => 2, 'tab' => 'SEO'],
            ['robots', 'Robots', 'select', 'options' => ['index, follow' => 'index, follow', 'noindex, follow' => 'noindex, follow', 'noindex, nofollow' => 'noindex, nofollow'], 'tab' => 'SEO'],
            ['og_image', 'Social share image (OG)', 'image', 'tab' => 'SEO'],
        ];
    }

    public static function get(string $res, $row = null): array
    {
        $status = ['status', 'Active', 'checkbox', 'default' => 1];
        $sort = ['sort_order', 'Sort order', 'number', 'default' => 0];
        $json = fn($n, $l, $h = '') => [$n, $l, 'json', 'rows' => 10, 'help' => $h, 'tab' => 'Advanced data'];
        switch ($res) {
            case 'sliders':
                return ['title' => 'Home Sliders', 'table' => 'sliders', 'order' => 'sort_order', 'cols' => ['image' => 'Image', 'title' => 'Title', 'link' => 'Link', 'sort_order' => 'Order', 'status' => 'Status'], 'search' => ['title'],
                    'fields' => [['title', 'Title (alt text)', 'text', 'req' => 1], ['image', 'Desktop banner', 'image', 'req' => 1], ['mobile_image', 'Mobile banner', 'image'], ['link', 'Link URL', 'text', 'help' => 'Example: /contact'], $sort, $status]];
            case 'testimonials':
                return ['title' => 'Testimonials', 'table' => 'testimonials', 'order' => 'sort_order', 'cols' => ['image' => 'Photo', 'name' => 'Name', 'role' => 'Role', 'rating' => 'Rating', 'status' => 'Status'], 'search' => ['name', 'message'],
                    'fields' => [['name', 'Name', 'text', 'req' => 1], ['role', 'Role / course', 'text'], ['image', 'Photo', 'image'], ['rating', 'Rating (1-5)', 'number', 'default' => 5], ['message', 'Message', 'textarea', 'req' => 1], $sort, $status]];
            case 'faqs':
                return ['title' => 'FAQs', 'table' => 'faqs', 'order' => 'page_key, sort_order', 'cols' => ['page_key' => 'Page', 'question' => 'Question', 'sort_order' => 'Order', 'status' => 'Status'], 'search' => ['question', 'answer'],
                    'fields' => [['page_key', 'Show on page', 'select', 'options' => ['home' => 'Home page', 'about' => 'About page']], ['question', 'Question', 'text', 'req' => 1], ['answer', 'Answer', 'textarea', 'rows' => 5, 'req' => 1], $sort, $status]];
            case 'blogs':
                return ['title' => 'Blogs', 'table' => 'blogs', 'order' => 'published_at DESC', 'cols' => ['image' => 'Image', 'title' => 'Title', 'category' => 'Category', 'published_at' => 'Published', 'status' => 'Status'], 'search' => ['title', 'category'], 'view' => '/blog/{slug}',
                    'fields' => array_merge([['title', 'Title', 'text', 'req' => 1], ['slug', 'URL slug', 'slug', 'from' => 'title', 'help' => 'Page opens at /blog/your-slug'], ['category', 'Category', 'text'], ['image', 'Cover image', 'image'], ['description', 'Short description (cards + SEO)', 'textarea', 'rows' => 3], ['content', 'Content', 'textarea', 'rows' => 18, 'editor' => 1], ['author', 'Author', 'text', 'default' => 'DuraSetu Team'], ['published_at', 'Publish date', 'datetime'], $status], array_slice(self::seo(), 0, 3))];
            case 'courses':
                return ['title' => 'Courses', 'table' => 'courses', 'order' => 'sort_order', 'cols' => ['title' => 'Title', 'level' => 'Level', 'duration' => 'Duration', 'popular' => 'Popular', 'status' => 'Status'], 'search' => ['title', 'full_name', 'slug'], 'view' => '/{slug}',
                    'fields' => array_merge([
                        ['cid', 'Course ID', 'text', 'req' => 1, 'lock' => 1, 'help' => 'Unique key, e.g. online-mba. Cannot change later.'],
                        ['slug', 'URL slug', 'slug', 'from' => 'cid', 'help' => 'Opens at /your-slug'],
                        ['title', 'Title', 'text', 'req' => 1], ['full_name', 'Full name', 'text'],
                        ['level', 'Level', 'select', 'options' => ['Undergraduate' => 'Undergraduate', 'Postgraduate' => 'Postgraduate', 'Integrated' => 'Integrated']],
                        ['category', 'Category', 'text'], ['duration', 'Duration', 'text'], ['mode', 'Mode', 'text', 'default' => 'Online'],
                        ['eligibility', 'Eligibility', 'textarea', 'rows' => 2], ['short_desc', 'Short description', 'textarea', 'rows' => 3],
                        ['icon', 'Icon class (Remix Icon)', 'text', 'default' => 'ri-graduation-cap-line'], ['image', 'Card image', 'image'], ['fallback_image', 'Fallback image', 'image'],
                        ['popular', 'Show on home (popular)', 'checkbox'], ['universities', 'Offered by universities', 'multi', 'pivot' => ['table' => 'course_university', 'self' => 'course_id', 'other' => 'university_id', 'pos' => 'course_pos', 'opt_table' => 'universities', 'opt_label' => 'name']],
                        $sort, $status,
                        $json('detail', 'Course page content (JSON)', 'Keys: full_title, program_badge, hero_desc, image, pill_top, pill_bottom, duration, mode, accreditation, eligibility, fee_desc, eligibility_desc, specialisations[], syllabus[], careers[], faqs[{q,a}]. Leave empty for the six hand-built pages (MBA, MCA, M.Com, BBA, BCA, B.Com).'),
                    ], self::seo())];
            case 'universities':
                return ['title' => 'Universities', 'table' => 'universities', 'order' => 'sort_order', 'cols' => ['logo' => 'Logo', 'name' => 'Name', 'slug' => 'Slug', 'sort_order' => 'Order', 'status' => 'Status'], 'search' => ['name', 'slug'], 'view' => '/{slug}',
                    'fields' => array_merge([
                        ['uid', 'University ID', 'text', 'req' => 1, 'lock' => 1, 'help' => 'Unique key used in compare links. Cannot change later.'],
                        ['slug', 'URL slug', 'slug', 'from' => 'uid', 'help' => 'Opens at /your-slug'],
                        ['name', 'Name', 'text', 'req' => 1], ['short_name', 'Short name', 'text'], ['logo', 'Logo', 'image'], ['campus_img', 'Campus image', 'image'],
                        ['subtitle', 'Subtitle', 'text'], ['hero_desc', 'Hero description', 'textarea', 'rows' => 3], ['since', 'Online since (year)', 'text'], ['learners', 'Learners', 'text'], ['rank_text', 'Rank / tagline', 'text'],
                        ['tag_theme', 'Card colour', 'select', 'options' => ['yellow' => 'yellow', 'blue' => 'blue', 'teal' => 'teal', 'purple' => 'purple', 'orange' => 'orange']],
                        ['about_p1', 'About paragraph 1', 'textarea', 'rows' => 4], ['about_p2', 'About paragraph 2', 'textarea', 'rows' => 4],
                        ['courses', 'Courses offered', 'multi', 'pivot' => ['table' => 'course_university', 'self' => 'university_id', 'other' => 'course_id', 'pos' => 'uni_pos', 'opt_table' => 'courses', 'opt_label' => 'title']],
                        $sort, $status,
                        $json('overview', 'Overview (JSON object)', '{"type":"Private University","recognition":"UGC-DEB","accreditation":"NAAC A+","mode":"Online","since":"2021","group":"..."}'),
                        $json('trust_badges', 'Trust badges (JSON list)', '[{"label":"UGC Entitled","type":"ugc","icon":"ri-checkbox-circle-fill"}]'),
                        $json('why_points', 'Why choose points (JSON list)', 'List of items exactly as they appear on the page'),
                        $json('approvals', 'Approvals (JSON list)', '[{"title":"","type":"","icon":"","desc":""}]'),
                        $json('fee_structure', 'Fee structure (JSON list)', '[{"program":"","duration":"","total":"","emi":""}]'),
                        $json('courses_list', 'Course pills (JSON list)', '[{"name":"","duration":"","fee":"","theme":"","icon":"","url":""}]'),
                        $json('course_details', 'Course details (JSON object, key = course id)', 'Per-course fee / duration / EMI details'),
                        $json('faqs', 'FAQs (JSON list)', '[{"q":"Question","a":"Answer"}]'),
                        $json('comparison_data', 'Comparison data (JSON object)', 'semester_fee, total_two_year_fee, approvals, naac_grade, nirf_ranking ...'),
                    ], self::seo())];
            case 'pages':
                $custom = $row ? !empty((json_decode($row->content ?? '', true) ?: [])['custom']) : true;
                $f = $row ? [['name', 'Page', 'text', 'lock' => $custom ? 0 : 1, 'req' => 1]] : [['name', 'Page title', 'text', 'req' => 1]];
                if ($custom) {
                    $f = array_merge($f, [
                        ['page_key', 'URL slug', 'slug', 'from' => 'name', 'lock' => 1, 'help' => 'Page opens at /your-slug. Cannot change later.'],
                        ['c_body', 'Page content', 'textarea', 'json' => 'body', 'rows' => 18, 'editor' => 1, 'tab' => 'Page content'],
                    ]);
                }
                if (($row->page_key ?? '') === 'about') {
                    $f = array_merge($f, [
                        ['c_title', 'Heading', 'text', 'json' => 'title', 'tab' => 'About section'], ['c_intro', 'Intro text', 'textarea', 'json' => 'intro', 'rows' => 3, 'tab' => 'About section'],
                        ['c_pill', 'Label', 'text', 'json' => 'pill', 'tab' => 'About section'], ['c_p1', 'Paragraph 1', 'textarea', 'json' => 'p1', 'rows' => 4, 'tab' => 'About section'],
                        ['c_p2', 'Paragraph 2', 'textarea', 'json' => 'p2', 'rows' => 4, 'tab' => 'About section'],
                        ['c_exp_number', 'Experience number', 'text', 'json' => 'exp_number', 'tab' => 'About section'], ['c_exp_label', 'Experience label', 'text', 'json' => 'exp_label', 'tab' => 'About section'],
                        ['c_image1', 'Image 1', 'image', 'json' => 'image1', 'tab' => 'About section'], ['c_image2', 'Image 2', 'image', 'json' => 'image2', 'tab' => 'About section'],
                    ]);
                }
                return ['title' => 'Pages & SEO', 'table' => 'pages', 'order' => 'id', 'custom_delete' => 1, 'cols' => ['name' => 'Page', 'page_key' => 'Slug', 'meta_title' => 'Meta title', 'robots' => 'Robots'], 'search' => ['name', 'page_key'], 'view' => '/{slug}', 'fields' => array_merge($f, self::seo())];
        }
        abort(404);
    }
}
