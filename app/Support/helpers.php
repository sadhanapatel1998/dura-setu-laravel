<?php
/**
 * DuraSetu data layer (DB backed). Keeps the same dura_* function names/array shapes
 * the original templates used, so the design/markup stays untouched.
 */

if (!function_exists('dura_pdo')) {
    function dura_pdo(): PDO
    {
        if (isset($GLOBALS['DURA_TEST_PDO'])) {
            return $GLOBALS['DURA_TEST_PDO'];
        }
        return \Illuminate\Support\Facades\DB::connection()->getPdo();
    }

    function dura_rows(string $sql, array $args = []): array
    {
        $st = dura_pdo()->prepare($sql);
        $st->execute($args);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    function dura_json($v, $default = [])
    {
        if ($v === null || $v === '') {
            return $default;
        }
        $d = json_decode($v, true);
        return is_array($d) ? $d : $default;
    }

    /** Global settings (one query per request). */
    function setting(string $key, $default = '')
    {
        if (!isset($GLOBALS['dura_settings'])) {
            $GLOBALS['dura_settings'] = [];
            try {
                foreach (dura_rows('SELECT k, v FROM settings') as $r) {
                    $GLOBALS['dura_settings'][$r['k']] = $r['v'];
                }
            } catch (\Throwable $e) {
            }
        }
        $v = $GLOBALS['dura_settings'][$key] ?? null;
        return ($v === null || $v === '') ? $default : $v;
    }

    function dura_flush_cache(): void
    {
        foreach (['dura_settings', 'dura_universities_cache', 'dura_courses_cache'] as $k) {
            unset($GLOBALS[$k]);
        }
    }

    /** Normalise legacy paths: assets/x -> asset URL, page.php -> /page */
    function dura_path(?string $p): string
    {
        $p = (string) $p;
        if ($p === '' || preg_match('#^(https?:|//|\#|tel:|mailto:)#', $p)) {
            return $p;
        }
        $clean = ltrim($p, '/');
        if (preg_match('#^public/(assets/|uploads/|storage/)#i', $clean)) {
            $clean = preg_replace('#^public/#i', '', $clean);
        }
        if (preg_match('#^(assets/|uploads/|storage/)#i', $clean)) {
            return asset($clean);
        }
        return url($clean);
    }

    /** Fix image/link paths inside editor HTML: /uploads/x.png, assets/x.png -> proper asset URL (/public/...) */
    function dura_fix_html(?string $html): string
    {
        return preg_replace_callback(
            '#\b(src|href|poster|data-src)=(["\'])/?((?:public/)?(?:assets|uploads|storage)/[^"\']*)\2#i',
            fn($m) => $m[1] . '=' . $m[2] . asset(preg_replace('#^public/#i', '', $m[3])) . $m[2],
            (string) $html
        );
    }

    function dura_asset(?string $p): string
    {
        $p = (string) $p;
        if ($p === '' || preg_match('#^(https?:|//|\#|tel:|mailto:)#', $p)) {
            return $p;
        }
        $clean = ltrim($p, '/');
        if (preg_match('#^public/(assets/|uploads/|storage/)#i', $clean)) {
            $clean = preg_replace('#^public/#i', '', $clean);
        }
        return asset($clean);
    }

    /** Generates safe URLs for admin panel supporting both subdirectories and root domains */
    function dura_admin(string $path = ''): string
    {
        $path = ltrim($path, '/');
        return url('admin' . ($path !== '' ? '/' . $path : ''));
    }

    function dura_site_url(): string
    {
        $u = trim((string) setting('site_url', ''));
        if ($u === '') {
            $u = url('/');
        }
        return rtrim(preg_replace('#^(https?://)www\.#i', '$1', $u), '/');
    }

    // ---------------------------------------------------------------- universities
    function dura_get_all_comparison_data(): array
    {
        $out = [];
        foreach (dura_get_all_universities() as $id => $u) {
            $out[$id] = $u['comparison_data'] ?? [];
        }
        return $out;
    }

    function dura_get_comparison_data(string $id): ?array
    {
        $u = dura_get_university($id);
        return $u['comparison_data'] ?? null;
    }

    function dura_get_all_universities(): array
    {
        if (isset($GLOBALS['dura_universities_cache'])) {
            return $GLOBALS['dura_universities_cache'];
        }
        $pivot = [];
        foreach (dura_rows('SELECT cu.university_id, c.cid FROM course_university cu JOIN courses c ON c.id = cu.course_id WHERE c.status = 1 ORDER BY cu.uni_pos, cu.course_id') as $r) {
            $pivot[$r['university_id']][] = $r['cid'];
        }
        $out = [];
        foreach (dura_rows('SELECT * FROM universities WHERE status = 1 ORDER BY sort_order, id') as $r) {
            $out[$r['uid']] = [
                'id' => $r['uid'],
                'db_id' => (int) $r['id'],
                'slug' => url($r['slug']),
                'raw_slug' => $r['slug'],
                'name' => $r['name'],
                'short_name' => $r['short_name'],
                'logo' => dura_path($r['logo']),
                'campus_img' => dura_path($r['campus_img']),
                'subtitle' => $r['subtitle'],
                'hero_desc' => $r['hero_desc'],
                'since' => $r['since'],
                'learners' => $r['learners'],
                'rank' => $r['rank_text'],
                'tag_theme' => $r['tag_theme'],
                'overview' => dura_json($r['overview']),
                'trust_badges' => dura_json($r['trust_badges']),
                'about_p1' => $r['about_p1'],
                'about_p2' => $r['about_p2'],
                'why_points' => dura_json($r['why_points']),
                'offered_courses' => $pivot[$r['id']] ?? [],
                'course_details' => dura_json($r['course_details']),
                'courses' => dura_json($r['courses_list']),
                'approvals' => dura_json($r['approvals']),
                'fee_structure' => dura_json($r['fee_structure']),
                'faqs' => dura_json($r['faqs']),
                'comparison_data' => dura_json($r['comparison_data']),
                'meta_title' => $r['meta_title'],
                'meta_description' => $r['meta_description'],
                'meta_keywords' => $r['meta_keywords'],
                'robots' => $r['robots'],
                'og_image' => $r['og_image'],
                'updated_at' => $r['updated_at'],
            ];
        }
        return $GLOBALS['dura_universities_cache'] = $out;
    }

    function dura_get_university(string $id): ?array
    {
        return dura_get_all_universities()[$id] ?? null;
    }

    function dura_get_university_by_slug(string $slug): ?array
    {
        $clean = ltrim($slug, '/');
        foreach (dura_get_all_universities() as $u) {
            if (($u['raw_slug'] ?? '') === $clean || $u['slug'] === '/' . $clean || $u['slug'] === url($clean)) {
                return $u;
            }
        }
        return null;
    }

    // ---------------------------------------------------------------- courses
    function dura_get_all_courses(): array
    {
        if (isset($GLOBALS['dura_courses_cache'])) {
            return $GLOBALS['dura_courses_cache'];
        }
        $pivot = [];
        foreach (dura_rows('SELECT cu.course_id, u.uid FROM course_university cu JOIN universities u ON u.id = cu.university_id WHERE u.status = 1 ORDER BY cu.course_pos, cu.university_id') as $r) {
            $pivot[$r['course_id']][] = $r['uid'];
        }
        $out = [];
        foreach (dura_rows('SELECT * FROM courses WHERE status = 1 ORDER BY sort_order, id') as $r) {
            $out[] = [
                'id' => $r['cid'],
                'db_id' => (int) $r['id'],
                'title' => $r['title'],
                'full_name' => $r['full_name'],
                'level' => $r['level'],
                'category' => $r['category'],
                'duration' => $r['duration'],
                'mode' => $r['mode'],
                'eligibility' => $r['eligibility'],
                'desc' => $r['short_desc'],
                'icon' => $r['icon'],
                'image' => dura_path($r['image']),
                'fallback_image' => dura_path($r['fallback_image']),
                'url' => url($r['slug']),
                'slug' => url($r['slug']),
                'raw_slug' => $r['slug'],
                'popular' => (bool) $r['popular'],
                'offering_universities' => $pivot[$r['id']] ?? [],
            ];
        }
        return $GLOBALS['dura_courses_cache'] = $out;
    }

    function dura_get_course(string $id): ?array
    {
        foreach (dura_get_all_courses() as $c) {
            if ($c['id'] === $id) {
                return $c;
            }
        }
        return null;
    }

    /** Full course row (with meta + detail JSON) by URL slug. */
    function dura_get_course_row_by_slug(string $slug): ?array
    {
        $r = dura_rows('SELECT * FROM courses WHERE slug = ? AND status = 1', [$slug]);
        return $r[0] ?? null;
    }

    /** Course page content (template courses). Accepts course id or slug. */
    function dura_get_course_detail(string $key): ?array
    {
        $r = dura_rows('SELECT * FROM courses WHERE (cid = ? OR slug = ?) AND detail IS NOT NULL AND detail <> \'\'', [$key, $key]);
        if (!$r) {
            return null;
        }
        $d = dura_json($r[0]['detail']);
        $d['id'] = $r[0]['cid'];
        $d['slug'] = url($r[0]['slug']);
        $d['raw_slug'] = $r[0]['slug'];
        foreach (['title', 'full_title', 'program_badge', 'hero_desc', 'image', 'duration', 'mode', 'eligibility'] as $k) {
            if (!isset($d[$k])) {
                $d[$k] = $k === 'title' ? $r[0]['title'] : '';
            }
        }
        $d['image'] = dura_path($d['image'] ?: $r[0]['image']);
        return $d;
    }

    function dura_get_courses_by_level(string $level): array
    {
        return array_values(array_filter(dura_get_all_courses(), fn($c) => strcasecmp($c['level'] ?? '', $level) === 0));
    }

    function dura_get_universities_for_course(string $course_id): array
    {
        $course = dura_get_course($course_id);
        $res = [];
        foreach ($course['offering_universities'] ?? [] as $uId) {
            if ($u = dura_get_university($uId)) {
                $res[$uId] = $u;
            }
        }
        return $res;
    }

    function dura_get_courses_for_university(string $university_id): array
    {
        $uni = dura_get_university($university_id);
        $res = [];
        foreach ($uni['offered_courses'] ?? [] as $cId) {
            if ($c = dura_get_course($cId)) {
                $res[] = $c;
            }
        }
        return $res;
    }

    function dura_compare_universities(array $university_ids): array
    {
        $na = 'Not Available';
        $compared = [];
        foreach ($university_ids as $id) {
            $uni = dura_get_university($id);
            if (!$uni) {
                continue;
            }
            $comp = $uni['comparison_data'] ?? [];
            $compared[$id] = [
                'id' => $uni['id'],
                'name' => $uni['name'],
                'short_name' => $uni['short_name'] ?: $uni['name'],
                'slug' => $uni['slug'] ?: url('universities'),
                'logo' => $uni['logo'],
                'campus_img' => $uni['campus_img'] ?? '',
                'hero_desc' => $uni['hero_desc'] ?? '',
                'type' => $uni['overview']['type'] ?? $na,
                'recognition' => $uni['overview']['recognition'] ?? 'UGC-DEB',
                'accreditation' => $uni['overview']['accreditation'] ?? $na,
                'semester_fee' => $comp['semester_fee'] ?? $na,
                'total_two_year_fee' => $comp['total_two_year_fee'] ?? ($comp['avg_fee_range'] ?? $na),
                'approvals' => $comp['approvals'] ?? ($uni['overview']['recognition'] ?? $na),
                'credit_points' => $comp['credit_points'] ?? $na,
                'eligibility' => $comp['eligibility'] ?? $na,
                'top_recruiters' => $comp['top_recruiters'] ?? $na,
                'duration' => $comp['duration'] ?? '2 Years',
                'education_mode' => $comp['education_mode'] ?? ($uni['overview']['mode'] ?? 'Online'),
                'elearning_facility' => $comp['elearning_facility'] ?? 'Yes',
                'alumni_status' => $comp['alumni_status'] ?? $na,
                'online_classes' => $comp['online_classes'] ?? 'Yes',
                'placement_assistance' => $comp['placement_assistance'] ?? 'Yes',
                'industry_ready_curriculum' => $comp['industry_ready_curriculum'] ?? 'Yes',
                'satisfied_students' => $comp['satisfied_students'] ?? $na,
                'pros' => $comp['pros'] ?? $na,
                'naac_grade' => $comp['naac_grade'] ?? ($uni['overview']['accreditation'] ?? $na),
                'naac_score' => $comp['naac_score'] ?? $na,
                'nirf_ranking' => $comp['nirf_ranking'] ?? ($uni['rank'] ?? $na),
                'wes_approval' => $comp['wes_approval'] ?? $na,
                'established_year' => $comp['established_year'] ?? ($uni['since'] ?? $na),
                'emi_available' => $comp['emi_available'] ?? $na,
                'students_visited' => $comp['students_visited'] ?? $na,
                'ugc_entitled' => $comp['ugc_entitled'] ?? 'Yes',
                'avg_fee_range' => $comp['avg_fee_range'] ?? $na,
                'exam_mode' => $comp['exam_mode'] ?? $na,
                'learning_mode' => $comp['learning_mode'] ?? $na,
                'course_details' => $uni['course_details'] ?? [],
                'offered_courses' => $uni['offered_courses'] ?? [],
            ];
        }
        return $compared;
    }

    function dura_search_universities(string $keyword = '', array $filters = []): array
    {
        $keyword = trim(strtolower($keyword));
        return array_filter(dura_get_all_universities(), function ($u) use ($keyword, $filters) {
            if ($keyword !== '' && strpos(strtolower($u['name'] . ' ' . $u['short_name'] . ' ' . $u['hero_desc']), $keyword) === false) {
                return false;
            }
            if (!empty($filters['naac']) && stripos($u['comparison_data']['naac_grade'] ?? '', $filters['naac']) === false) {
                return false;
            }
            if (!empty($filters['type']) && stripos($u['overview']['type'] ?? '', $filters['type']) === false) {
                return false;
            }
            return true;
        });
    }

    function dura_get_course_universities_list(string $course_id, array $default_fallback = []): array
    {
        $unis = dura_get_universities_for_course($course_id);
        if (!$unis) {
            return array_map(function ($u) {
                $u['logo'] = dura_path($u['logo'] ?? '');
                return $u;
            }, $default_fallback);
        }
        $course = dura_get_course($course_id);
        $list = [];
        foreach ($unis as $uni) {
            $cd = $uni['course_details'][$course_id] ?? null;
            $list[] = [
                'id' => $uni['id'],
                'name' => $uni['name'],
                'logo' => dura_path($uni['logo']),
                'alt' => $uni['name'],
                'badge' => $uni['overview']['recognition'] ?? 'UGC-DEB',
                'accreditation' => $uni['overview']['accreditation'] ?? 'NAAC Accredited',
                'duration' => $cd['duration'] ?? ($course['duration'] ?? '2 Years'),
                'fee' => $cd['fee'] ?? ($uni['comparison_data']['avg_fee_range'] ?? 'Fees On Request'),
                'emi' => $cd['emi'] ?? ($uni['comparison_data']['emi_available'] ?? 'EMI Available'),
                'url' => $uni['slug'],
            ];
        }
        return $list ?: array_map(function ($u) {
            $u['logo'] = dura_path($u['logo'] ?? '');
            return $u;
        }, $default_fallback);
    }

    function dura_get_homepage_slider_universities(): array
    {
        $themes = ['yellow', 'blue', 'teal', 'purple', 'orange'];
        $slider = [];
        $i = 0;
        foreach (dura_get_all_universities() as $uni) {
            $tags = [];
            foreach (array_slice($uni['offered_courses'], 0, 4) as $cId) {
                if ($c = dura_get_course($cId)) {
                    $tags[] = preg_replace('/^(Online\s+|Global\s+|1-Year\s+|Executive\s+)/i', '', $c['title']);
                }
            }
            $tags = $tags ?: ['Online Programs', 'Degree'];
            $accred = $uni['overview']['recognition'] ?? 'UGC-DEB';
            if (!empty($uni['overview']['accreditation']) && $uni['overview']['accreditation'] !== 'Not Available') {
                $accred .= ' | ' . $uni['overview']['accreditation'];
            }
            $slider[] = [
                'id' => $uni['id'],
                'name' => $uni['name'],
                'accreditation' => $accred,
                'image' => dura_path($uni['campus_img'] ?: '/assets/img/course-img-1.jpg'),
                'fallback_image' => dura_path('/assets/img/course-img-1.jpg'),
                'logo' => dura_path($uni['logo'] ?: '/assets/img/icons/graduation-cap.svg'),
                'fallback_logo' => dura_path('/assets/img/icons/graduation-cap.svg'),
                'alt' => $uni['name'],
                'tag_theme' => $themes[$i % count($themes)],
                'courses' => $tags,
                'url' => $uni['slug'] ?: url('universities'),
            ];
            $i++;
        }
        return $slider;
    }

    function dura_get_homepage_marquee_universities(): array
    {
        return array_values(array_map(fn($u) => ['name' => $u['name'], 'logo' => $u['logo'], 'alt' => $u['name']], dura_get_all_universities()));
    }

    function dura_get_popular_courses_list(int $limit = 6): array
    {
        $out = [];
        foreach (dura_get_all_courses() as $c) {
            if (!empty($c['popular'])) {
                $out[] = [
                    'id' => $c['id'],
                    'title' => $c['title'],
                    'subtitle' => $c['full_name'] ?: $c['title'],
                    'desc' => $c['desc'] ?? '',
                    'duration' => $c['duration'] ?: '2 Years',
                    'mode' => $c['mode'] ?: 'Online',
                    'icon' => $c['icon'] ?: 'ri-graduation-cap-line',
                    'image' => dura_path($c['image'] ?: '/assets/img/course-img-1.jpg'),
                    'fallback_image' => dura_path($c['fallback_image'] ?: '/assets/img/course-img-1.jpg'),
                    'level' => $c['level'] ?: 'Postgraduate',
                    'url' => $c['url'],
                ];
            }
        }
        return array_slice($out, 0, $limit);
    }

    function dura_search_courses(string $keyword = '', string $level = ''): array
    {
        $keyword = trim(strtolower($keyword));
        return array_values(array_filter(dura_get_all_courses(), function ($c) use ($keyword, $level) {
            if ($level !== '' && strcasecmp($c['level'] ?? '', $level) !== 0) {
                return false;
            }
            return $keyword === '' || strpos(strtolower($c['title'] . ' ' . $c['full_name'] . ' ' . $c['desc']), $keyword) !== false;
        }));
    }

    // ---------------------------------------------------------------- page data
    function dura_blog_card(array $b): array
    {
        return [
            'title' => $b['title'],
            'category' => $b['category'],
            'image' => dura_path($b['image']),
            'description' => $b['description'],
            'url' => url('blog/' . $b['slug']),
            'slug' => $b['slug'],
            'published_at' => $b['published_at'],
        ];
    }

    function dura_get_blogs(int $limit = 12): array
    {
        $rows = dura_rows('SELECT * FROM blogs WHERE status = 1 ORDER BY published_at DESC, id DESC LIMIT ' . (int) $limit);
        return array_map('dura_blog_card', $rows);
    }

    function dura_get_faqs(string $page): array
    {
        return dura_rows('SELECT question, answer FROM faqs WHERE page_key = ? AND status = 1 ORDER BY sort_order, id', [$page]);
    }

    function dura_get_page(string $key): array
    {
        $r = dura_rows('SELECT * FROM pages WHERE page_key = ?', [$key])[0] ?? [];
        $r['content_arr'] = dura_json($r['content'] ?? null);
        return $r;
    }

    function dura_page_data(): array
    {
        if (isset($GLOBALS['dura_page_data'])) {
            return $GLOBALS['dura_page_data'];
        }
        $categories = [
            ['title' => 'Online MBA', 'duration' => '2 Years', 'category' => 'Business & Management', 'image' => '/assets/img/category/mba.png', 'fallback' => '/assets/img/category/cat-1.png', 'color' => 'yellow', 'url' => url('online-mba'), 'delay' => 0, 'alt' => 'Online MBA'],
            ['title' => 'Online MCA', 'duration' => '2 Years', 'category' => 'Computer Applications', 'image' => '/assets/img/category/mca.png', 'fallback' => '/assets/img/category/cat-2.png', 'color' => 'blue', 'url' => url('online-mca'), 'delay' => 100, 'alt' => 'Online MCA'],
            ['title' => 'Online M.Com', 'duration' => '2 Years', 'category' => 'Commerce & Finance', 'image' => '/assets/img/category/mcom.png', 'fallback' => '/assets/img/category/cat-3.png', 'color' => 'teal', 'url' => url('online-mcom'), 'delay' => 200, 'alt' => 'Online M.Com'],
            ['title' => 'Online BBA', 'duration' => '3 Years', 'category' => 'Business Administration', 'image' => '/assets/img/category/bba.png', 'fallback' => '/assets/img/category/cat-4.png', 'color' => 'purple', 'url' => url('online-bba'), 'delay' => 300, 'alt' => 'Online BBA'],
            ['title' => 'Online BCA', 'duration' => '3 Years', 'category' => 'Computer Applications', 'image' => '/assets/img/category/bca.png', 'fallback' => '/assets/img/category/cat-5.png', 'color' => 'skyblue', 'url' => url('online-bca'), 'delay' => 0, 'alt' => 'Online BCA'],
            ['title' => 'Online B.Com', 'duration' => '3 Years', 'category' => 'Commerce', 'image' => '/assets/img/category/bcom.png', 'fallback' => '/assets/img/category/cat-6.png', 'color' => 'pink', 'url' => url('online-bcom'), 'delay' => 100, 'alt' => 'Online B.Com'],
            ['title' => 'Online Degrees', 'duration' => 'UG & PG', 'category' => 'Programs', 'image' => '/assets/img/category/degree.png', 'fallback' => '/assets/img/category/cat-7.png', 'color' => 'orange', 'url' => url('universities'), 'delay' => 200, 'alt' => 'Online Degrees'],
            ['title' => 'Online Universities', 'duration' => 'Top UGC-Recognized', 'category' => 'Options', 'image' => '/assets/img/category/university.png', 'fallback' => '/assets/img/category/cat-8.png', 'color' => 'navy', 'url' => url('universities'), 'delay' => 300, 'alt' => 'Online Universities'],
        ];
        $categories = array_map(function ($cat) {
            $cat['image'] = dura_path($cat['image']);
            $cat['fallback'] = dura_path($cat['fallback'] ?: $cat['image']);
            return $cat;
        }, $categories);
        $testimonials = array_map(function ($t) {
            $t['image'] = dura_path($t['image']);
            return $t;
        }, dura_rows('SELECT * FROM testimonials WHERE status = 1 ORDER BY sort_order, id'));
        $sliders = array_map(function ($s) {
            $s['image'] = dura_path($s['image']);
            $s['mobile_image'] = dura_path($s['mobile_image'] ?: $s['image']);
            return $s;
        }, dura_rows('SELECT * FROM sliders WHERE status = 1 ORDER BY sort_order, id'));
        return $GLOBALS['dura_page_data'] = [
            'universities' => dura_get_homepage_slider_universities(),
            'marquee_universities' => dura_get_homepage_marquee_universities(),
            'categories' => $categories,
            'popular_courses' => dura_get_popular_courses_list(12),
            'testimonials' => $testimonials,
            'blogs' => dura_get_blogs(9),
            'sliders' => $sliders,
            'all_universities_data' => dura_get_all_universities(),
            'all_courses_data' => dura_get_all_courses(),
        ];
    }
}

// ====================================================================== SEO
if (!function_exists('dura_abs')) {
    function dura_abs(?string $p): string
    {
        $p = (string) $p;
        if ($p === '') {
            return '';
        }
        return preg_match('#^https?://#i', $p) ? $p : dura_site_url() . '/' . ltrim($p, '/');
    }

    /** Build the meta array used by layouts/site.blade.php. */
    function dura_meta(array $o = []): array
    {
        $path = '/' . trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '', '/');
        $m = [
            'title' => $o['title'] ?? '' ?: setting('default_title', setting('site_name', 'DuraSetu')),
            'description' => ($o['description'] ?? '') ?: setting('default_description'),
            'keywords' => ($o['keywords'] ?? '') ?: setting('default_keywords'),
            'robots' => ($o['robots'] ?? '') ?: 'index, follow',
            'canonical' => dura_site_url() . ($path === '/' ? '/' : $path),
            'og_image' => dura_abs(($o['og_image'] ?? '') ?: setting('default_og_image')),
            'og_type' => $o['og_type'] ?? 'website',
            'schema' => $o['schema'] ?? [],
            'turnstile' => !empty($o['turnstile']),
        ];
        $m['schema'][] = dura_org_schema();
        if (!empty($o['crumbs'])) {
            $m['schema'][] = dura_breadcrumb_schema($o['crumbs']);
        }
        return $m;
    }

    function dura_org_schema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'EducationalOrganization',
            'name' => setting('site_name', 'DuraSetu'),
            'url' => dura_site_url() . '/',
            'logo' => dura_abs(setting('logo', '/assets/img/logo/logo.png')),
            'email' => setting('email'),
            'telephone' => '+' . setting('phone'),
        ];
    }

    /** $crumbs = [['Home','/'],['About','/about']] */
    function dura_breadcrumb_schema(array $crumbs): array
    {
        $items = [];
        foreach ($crumbs as $i => [$name, $url]) {
            $items[] = ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $name, 'item' => dura_abs($url)];
        }
        return ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $items];
    }

    function dura_faq_schema(array $faqs, string $q = 'q', string $a = 'a'): ?array
    {
        $ents = [];
        foreach ($faqs as $f) {
            if (!empty($f[$q]) && !empty($f[$a])) {
                $ents[] = ['@type' => 'Question', 'name' => $f[$q], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => strip_tags($f[$a])]];
            }
        }
        return $ents ? ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $ents] : null;
    }

    /** Fill "page meta" row into dura_meta() overrides. */
    function dura_page_meta(string $key, array $extra = []): array
    {
        $p = dura_get_page($key);
        return dura_meta($extra + [
            'title' => $p['meta_title'] ?? '',
            'description' => $p['meta_description'] ?? '',
            'keywords' => $p['meta_keywords'] ?? '',
            'robots' => $p['robots'] ?? '',
            'og_image' => $p['og_image'] ?? '',
        ]);
    }
}