
<?php $__env->startSection('content'); ?>
    <?php
        extract(dura_page_data());
        $ab = array_merge([
            'image1' => 'assets/img/about-one.jpg',
            'image2' => 'assets/img/about-two.jpg',
            'exp_number' => '5+',
            'exp_label' => 'Years Counseling Expertise'
        ], dura_get_page('about')['content_arr'] ?? []);
    ?>

    <style>
        /* ==========================================================================
                               DuraSetu About Page Premium Design Stylesheet
                               Harmonized with website variables and native typography
                               ========================================================================== */

        :root {
            --ds-navy: #02234f;
            --ds-blue: #002671;
            --ds-orange: #fc9502;
            --ds-orange-hover: #e58600;
            --ds-slate: #526078;
            --ds-slate-light: #64748b;
            --ds-border: #e2e8f0;
            --ds-bg-soft: #f8fafc;
            --ds-card-shadow: 0 10px 30px rgba(2, 35, 79, 0.06);
            --ds-card-hover-shadow: 0 16px 36px rgba(2, 35, 79, 0.12);
        }

        .ds_about_wrap {
            font-family: var(--secondary-font, "Open Sans", sans-serif);
            color: var(--ds-slate);
            /* overflow-x: hidden; */
        }

        .ds_about_wrap h1,
        .ds_about_wrap h2,
        .ds_about_wrap h3,
        .ds_about_wrap h4 {
            font-family: var(--heading-font, "BreveNews-SemiBold", serif);
            color: var(--ds-navy);
            font-weight: 700;
            line-height: 1.28;
        }

        .ds_about_wrap h1 span,
        .ds_about_wrap h2 span,
        .ds_about_wrap h3 span,
        .ds_about_wrap h4 span,
        .ds_accent_txt {
            color: var(--ds-orange) !important;
        }

        /* Category Pill */
        .ds_pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 18px;
            background: #fff6eb;
            color: var(--ds-orange);
            border: 1px solid rgba(252, 149, 2, 0.3);
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.3px;
            margin-bottom: 14px;
        }

        .ds_pill i {
            font-size: 16px;
        }

        /* Hero Section */
        .ds_hero_section {
            background: linear-gradient(135deg, #02234f 0%, #00193e 100%);
            position: relative;
            padding: 70px 0 65px;
            color: #ffffff;
            overflow: hidden;
        }

        .ds_hero_section::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle at 85% 20%, rgba(252, 149, 2, 0.15) 0%, transparent 45%),
                radial-gradient(circle at 15% 85%, rgba(0, 38, 113, 0.35) 0%, transparent 55%),
                linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
            background-size: 100% 100%, 100% 100%, 36px 36px, 36px 36px;
            pointer-events: none;
        }

        .ds_hero_breadcrumb {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 16px;
            color: #94a3b8;
            margin-bottom: 18px;
        }

        .ds_hero_breadcrumb a {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.2s;
        }

        .ds_hero_breadcrumb a:hover {
            color: var(--ds-orange);
        }

        .ds_hero_badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 18px;
            background: rgba(252, 149, 2, 0.12);
            border: 1px solid rgba(252, 149, 2, 0.45);
            border-radius: 50px;
            color: var(--ds-orange);
            font-size: 13.5px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .ds_hero_title {
            font-size: clamp(28px, 4vw, 46px);
            font-weight: 700;
            color: #ffffff !important;
            max-width: 960px;
            margin: 0 auto 20px;
        }

        .ds_hero_lead {
            font-size: clamp(15px, 1.2vw, 17px);
            line-height: 1.8;
            color: #cbd5e1;
            max-width: 900px;
            margin: 0 auto 30px;
        }

        .ds_hero_btns {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 28px;
        }

        .ds_btn_primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--ds-orange);
            color: #ffffff !important;
            padding: 14px 32px;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 18px rgba(252, 149, 2, 0.35);
        }

        .ds_btn_primary:hover {
            background: var(--ds-orange-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(252, 149, 2, 0.5);
        }

        .ds_btn_secondary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff !important;
            border: 1.5px solid rgba(255, 255, 255, 0.35);
            padding: 14px 28px;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            backdrop-filter: blur(4px);
        }

        .ds_btn_secondary:hover {
            background: #ffffff;
            color: var(--ds-blue) !important;
            border-color: #ffffff;
            transform: translateY(-2px);
        }

        .ds_hero_trust_row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 24px;
            flex-wrap: wrap;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .ds_trust_item {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 13.5px;
            color: #cbd5e1;
        }

        .ds_trust_item i {
            color: var(--ds-orange);
            font-size: 16px;
        }

        /* ==========================================================================
                               SHARED IMAGE SECTION (FIXED & HIGHLY ATTRACTIVE)
                               ========================================================================== */
        .ds_story_section {
            padding: 80px 0 70px;
            background: #ffffff;
            position: relative;
        }

        .ds_story_collage {
            position: relative;
            max-width: 500px;
            margin: 0 auto;
        }

        /* Main Image */
        .ds_story_main_img {
            width: 85%;
            margin-left: 15%;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 45px rgba(2, 35, 79, 0.12);
            border: 5px solid #ffffff;
            position: relative;
            z-index: 2;
        }

        .ds_story_main_img img {
            width: 100%;
            height: 380px;
            object-fit: cover;
            display: block;
            transition: transform 0.5s ease;
        }

        .ds_story_collage:hover .ds_story_main_img img {
            transform: scale(1.03);
        }

        /* Secondary Floating Image */
        .ds_story_sub_img {
            position: absolute;
            top: -24px;
            left: 0;
            width: 48%;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(2, 35, 79, 0.15);
            border: 4px solid #ffffff;
            z-index: 3;
        }

        .ds_story_sub_img img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            display: block;
        }

        /* Experience Badge */
        .ds_story_exp_badge {
            position: absolute;
            bottom: -15px;
            right: 0;
            background: #ffffff;
            padding: 16px 22px;
            border-radius: 18px;
            box-shadow: 0 14px 35px rgba(2, 35, 79, 0.14);
            border: 1px solid #edf2f7;
            z-index: 4;
            display: flex;
            align-items: center;
            gap: 14px;
            animation: ds_float_gentle 4s ease-in-out infinite;
        }

        @keyframes ds_float_gentle {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-6px);
            }
        }

        .ds_exp_icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: #fff4e5;
            color: var(--ds-orange);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
        }

        .ds_exp_num {
            font-family: var(--heading-font, "BreveNews-SemiBold", serif);
            font-size: 26px;
            font-weight: 700;
            color: var(--ds-navy);
            line-height: 1;
            margin-bottom: 4px;
        }

        .ds_exp_lbl {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--ds-slate-light);
            line-height: 1.25;
        }

        /* Secondary Trust Tag on Collage */
        .ds_story_verified_tag {
            position: absolute;
            bottom: 25px;
            left: -10px;
            background: #ffffff;
            padding: 10px 16px;
            border-radius: 50px;
            box-shadow: 0 10px 25px rgba(2, 35, 79, 0.12);
            border: 1px solid #edf2f7;
            z-index: 4;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 700;
            color: var(--ds-navy);
        }

        .ds_story_verified_tag i {
            color: #10b981;
            font-size: 16px;
        }

        /* Story Right Content */
        .ds_story_content {
            padding-left: 20px;
        }

        @media (max-width: 991px) {
            .ds_story_content {
                padding-left: 0;
                margin-top: 40px;
            }
        }

        .ds_story_title {
            font-size: clamp(25px, 2.8vw, 36px);
            margin-bottom: 20px;
            line-height: 1.32;
        }

        .ds_story_lead {
            font-size: 16px;
            line-height: 1.8;
            color: #334155;
            margin-bottom: 20px;
        }

        /* Arpan Sangam Firsthand Experience Callout */
        .ds_story_callout {
            background: #f8fafc;
            border-left: 4px solid var(--ds-orange);
            border-radius: 0 16px 16px 0;
            padding: 22px 24px;
            margin: 22px 0;
            position: relative;
            box-shadow: 0 4px 15px rgba(2, 35, 79, 0.03);
        }

        .ds_callout_icon {
            font-size: 24px;
            color: var(--ds-orange);
            margin-bottom: 8px;
            display: block;
        }

        .ds_story_callout p {
            font-size: 16px;
            line-height: 1.75;
            color: #475569;
            margin-bottom: 0;
        }

        .ds_story_footer_text {
            font-size: 16px;
            line-height: 1.8;
            color: #475569;
            margin-bottom: 22px;
        }

        .ds_story_features {
            display: flex;
            flex-wrap: wrap;
            gap: 12px 24px;
            margin-bottom: 26px;
        }

        .ds_story_feat_item {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
            font-weight: 600;
            color: var(--ds-navy);
        }

        .ds_story_feat_item i {
            color: #10b981;
            font-size: 17px;
        }

        /* ==========================================================================
                               3-PILLAR FRAMEWORK (ELEGANT DURASETU BLUE CONTAINER)
                               ========================================================================== */
        .ds_pillars_section {
            padding: 40px 0 70px;
        }

        .ds_pillars_container {
            background: linear-gradient(135deg, #002671 0%, #021a48 100%);
            border-radius: 24px;
            padding: 60px 48px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 16px 40px rgba(0, 38, 113, 0.25);
        }

        .ds_pillars_container::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle at 90% 10%, rgba(252, 149, 2, 0.15) 0%, transparent 40%),
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 100% 100%, 30px 30px, 30px 30px;
            pointer-events: none;
        }

        .ds_pillar_card {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 18px;
            padding: 34px 26px;
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
            transition: all 0.35s ease;
            backdrop-filter: blur(8px);
        }

        .ds_pillar_card:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(252, 149, 2, 0.7);
            transform: translateY(-6px);
            box-shadow: 0 16px 35px rgba(0, 0, 0, 0.25);
        }

        .ds_pillar_header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .ds_pillar_icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: rgba(252, 149, 2, 0.15);
            border: 1px solid rgba(252, 149, 2, 0.3);
            color: var(--ds-orange);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            transition: all 0.3s ease;
        }

        .ds_pillar_card:hover .ds_pillar_icon {
            background: var(--ds-orange);
            color: #ffffff;
            transform: scale(1.08);
        }

        .ds_pillar_num {
            font-family: var(--heading-font, "BreveNews-SemiBold", serif);
            font-size: 22px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.35);
        }

        .ds_pillar_card:hover .ds_pillar_num {
            color: var(--ds-orange);
        }

        .ds_pillar_title {
            font-size: 21px;
            font-weight: 700;
            color: #ffffff !important;
            margin-bottom: 10px;
        }

        .ds_pillar_delivers {
            font-size: 13.5px;
            font-weight: 700;
            color: #fc9502;
            margin-bottom: 12px;
            line-height: 1.5;
        }

        .ds_pillar_desc {
            font-size: 16px;
            line-height: 1.7;
            color: #cbd5e1;
            margin-bottom: 20px;
            flex-grow: 1;
        }

        .ds_pillar_link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #ffffff;
            font-size: 16px;
            font-weight: 700;
            text-decoration: none;
            transition: gap 0.2s, color 0.2s;
        }

        .ds_pillar_link i {
            color: var(--ds-orange);
            transition: transform 0.2s;
        }

        .ds_pillar_link:hover {
            color: var(--ds-orange);
        }

        .ds_pillar_link:hover i {
            transform: translateX(4px);
        }

        /* ==========================================================================
                               MISSION & VISION SECTION
                               ========================================================================== */
        .ds_mv_section {
            padding: 70px 0 60px;
            background: #f8fafc;
        }

        .ds_mv_card {
            background: #ffffff;
            border: 1px solid var(--ds-border);
            border-radius: 20px;
            padding: 40px 32px;
            height: 100%;
            box-shadow: var(--ds-card-shadow);
            transition: all 0.35s ease;
            position: relative;
            overflow: hidden;
        }

        .ds_mv_card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
        }

        .ds_mission_card::before {
            background: var(--ds-orange);
        }

        .ds_vision_card::before {
            background: var(--ds-blue);
        }

        .ds_mv_card:hover {
            transform: translateY(-5px);
            box-shadow: var(--ds-card-hover-shadow);
        }

        .ds_mv_icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 22px;
        }

        .ds_mission_card .ds_mv_icon {
            background: #fff4e5;
            color: var(--ds-orange);
        }

        .ds_vision_card .ds_mv_icon {
            background: #eef4ff;
            color: var(--ds-blue);
        }

        .ds_mv_card h3 {
            font-size: 24px;
            margin-bottom: 14px;
        }

        .ds_mv_card p {
            font-size: 16px;
            line-height: 1.8;
            color: var(--ds-slate);
            margin-bottom: 0;
        }

        /* ==========================================================================
                               COUNTER STRIP (DARK NAVY VERIFICATION & AUTHORITY STANDARDS)
                               ========================================================================== */
        .ds_counter_strip {
            background: #021f4f;
            padding: 65px 0;
            position: relative;
            color: #ffffff;
        }

        .ds_counter_grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        @media (max-width: 991px) {
            .ds_counter_grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 575px) {
            .ds_counter_grid {
                grid-template-columns: 1fr;
            }
        }

        .ds_counter_box {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 18px;
            padding: 26px 22px;
            transition: all 0.3s ease;
            backdrop-filter: blur(4px);
        }

        .ds_counter_box:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(252, 149, 2, 0.6);
            transform: translateY(-4px);
        }

        .ds_counter_num {
            font-family: var(--heading-font, "BreveNews-SemiBold", serif);
            font-size: clamp(34px, 3.2vw, 42px);
            font-weight: 700;
            color: var(--ds-orange);
            line-height: 1;
            margin-bottom: 10px;
        }

        .ds_counter_title {
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 8px;
            line-height: 1.35;
        }

        .ds_counter_desc {
            font-size: 13.5px;
            line-height: 1.6;
            color: #94a3b8;
            margin-bottom: 0;
        }

        /* ==========================================================================
                               WHY CHOOSE DURASETU (6-CARD GRID)
                               ========================================================================== */
        .ds_why_section {
            padding: 70px 0 60px;
            background: #ffffff;
        }

        .ds_why_grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        @media (max-width: 991px) {
            .ds_why_grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 767px) {
            .ds_why_grid {
                grid-template-columns: 1fr;
            }
        }

        .ds_why_card {
            background: #ffffff;
            border: 1px solid var(--ds-border);
            border-radius: 18px;
            padding: 28px 24px;
            height: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(2, 35, 79, 0.03);
            display: flex;
            flex-direction: column;
        }

        .ds_why_card:hover {
            border-color: rgba(0, 38, 113, 0.3);
            box-shadow: var(--ds-card-hover-shadow);
            transform: translateY(-4px);
        }

        .ds_why_header {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 14px;
        }

        .ds_why_icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #eef4ff;
            color: var(--ds-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .ds_why_card:hover .ds_why_icon {
            background: #fff4e5;
            color: var(--ds-orange);
        }

        .ds_why_title {
            color: #022670;
            font-size: 17.5px;
            font-weight: 700;
            line-height: 1.35;
            margin-bottom: 0;
        }

        .ds_why_body {
            font-size: 16px;
            line-height: 1.75;
            color: var(--ds-slate);
            margin-bottom: 0;
        }

        /* ==========================================================================
                               PROGRAMS & REGULATORY APPROVALS
                               ========================================================================== */
        .ds_prog_section {
            padding: 70px 0 60px;
            background: #f8fafc;
        }

        .ds_prog_lead {
            font-size: 16px;
            line-height: 1.8;
            color: var(--ds-slate);
            max-width: 860px;
            margin: 0 auto 36px;
            text-align: center;
        }

        .ds_prog_grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }

        .ds_prog_grid .ds_prog_card_full {
            grid-column: span 2;
        }

        @media (max-width: 767px) {
            .ds_prog_grid {
                grid-template-columns: 1fr;
            }

            .ds_prog_grid .ds_prog_card_full {
                grid-column: span 1;
            }
        }

        .ds_prog_card {
            background: #ffffff;
            border: 1px solid var(--ds-border);
            border-radius: 18px;
            padding: 28px 26px;
            box-shadow: 0 4px 15px rgba(2, 35, 79, 0.03);
            transition: all 0.3s ease;
        }

        .ds_prog_card:hover {
            border-color: rgba(252, 149, 2, 0.5);
            box-shadow: var(--ds-card-hover-shadow);
            transform: translateY(-3px);
        }

        .ds_prog_header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 12px;
        }

        .ds_prog_icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: #eef4ff;
            color: var(--ds-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
            flex-shrink: 0;
        }

        .ds_prog_card_full .ds_prog_icon {
            background: #fff4e5;
            color: var(--ds-orange);
        }

        .ds_prog_card .ds_prog_title {
            color: #1d3861;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 0;
        }

        .ds_prog_card p {
            font-size: 15px;
            line-height: 1.75;
            color: var(--ds-slate);
            margin-bottom: 0;
        }

        /* ==========================================================================
                               LEADERSHIP & COUNSELING TEAM
                               ========================================================================== */
        .ds_team_section {
            padding: 70px 0 60px;
            background: #ffffff;
        }

        .ds_team_card {
            background: #ffffff;
            border: 1px solid var(--ds-border);
            border-radius: 20px;
            padding: 36px 30px;
            height: 100%;
            transition: all 0.35s ease;
            box-shadow: var(--ds-card-shadow);
            display: flex;
            flex-direction: column;
        }

        .ds_team_card:hover {
            border-color: rgba(0, 38, 113, 0.3);
            box-shadow: var(--ds-card-hover-shadow);
            transform: translateY(-4px);
        }

        .ds_team_badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #eef4ff;
            color: var(--ds-blue);
            font-size: 12.5px;
            font-weight: 700;
            padding: 5px 14px;
            border-radius: 50px;
            margin-bottom: 16px;
            align-self: flex-start;
        }

        .ds_team_name {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 14px;
            line-height: 1.35;
        }

        .ds_team_bio {
            font-size: 16px;
            line-height: 1.8;
            color: var(--ds-slate);
            margin-bottom: 0;
        }

        /* ==========================================================================
                               4-STEP PROCESS & DISCLAIMER
                               ========================================================================== */
        .ds_steps_section {
            padding: 70px 0 60px;
            background: #f8fafc;
        }

        .ds_step_card {
            background: #ffffff;
            border: 1px solid var(--ds-border);
            border-radius: 18px;
            padding: 28px 22px;
            height: 100%;
            box-shadow: 0 4px 15px rgba(2, 35, 79, 0.03);
            transition: all 0.3s ease;
        }

        .ds_step_card:hover {
            border-color: rgba(252, 149, 2, 0.5);
            box-shadow: var(--ds-card-hover-shadow);
            transform: translateY(-4px);
        }

        .ds_step_num {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--ds-navy);
            color: #ffffff;
            font-family: var(--heading-font, "BreveNews-SemiBold", serif);
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 14px;
        }

        .ds_step_title {
            font-size: 17.5px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .ds_step_desc {
            font-size: 15px;
            line-height: 1.7;
            color: var(--ds-slate);
            margin-bottom: 0;
        }

        /* Official Disclaimer Box */
        .ds_disclaimer_box {
            margin-top: 48px;
            background: #ffffff;
            border: 1.5px dashed #cbd5e1;
            border-left: 5px solid var(--ds-orange);
            border-radius: 16px;
            padding: 28px 30px;
            box-shadow: 0 6px 20px rgba(2, 35, 79, 0.03);
        }

        .ds_disclaimer_title {
            font-size: 18px;
            font-weight: 700;
            color: var(--ds-navy);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .ds_disclaimer_title i {
            color: var(--ds-orange);
            font-size: 22px;
        }

        .ds_disclaimer_text {
            font-size: 16px;
            line-height: 1.8;
            color: var(--ds-slate);
            margin-bottom: 0;
        }

        @media (max-width: 767px) {
            .ds_hero_section {
                padding: 50px 0 45px;
            }

            .ds_story_section,
            .ds_pillars_section,
            .ds_mv_section,
            .ds_counter_strip,
            .ds_why_section,
            .ds_prog_section,
            .ds_team_section,
            .ds_steps_section {
                padding: 45px 0;
            }

            .ds_pillars_container {
                padding: 35px 20px;
            }
        }

        .cs_work_step_title {
            font-size: 18px !important;
            font-weight: 500 !important;
            max-height: 60px;
        }
    </style>

    <main class="ds_about_wrap">

        <!-- Start Page Header -->
        <section class="cs_page_header cs_bg_filed" data-src="<?php echo e(asset('assets/img/breadcrumb-bg.jpg')); ?>">
            <div class="container">
                <div class="cs_page_header_text" data-aos="fade-up">
                    <h1 class="cs_page_header_title cs_fs_48 cs_bold">About Us</h1>
                    <ul class="cs_breadcrumb cs_mp_0 cs_fs_16">
                        <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
                        <li>About DuraSetu</li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- End Page Header -->

        <!-- 1. HERO SECTION (INTERACTIVE & HIGH IMPACT) -->
        <section class="ds_hero_section text-center">
            <div class="container position-relative z-1">
                <span class="ds_hero_badge">
                    <i class="ri-shield-check-fill"></i> India's Student-First Higher Education Bridge
                </span>

                <h2 class="ds_hero_title">
                    About DuraSetu: Your Trusted Bridge to <span>Verified Online &amp; Distance Higher Education</span>
                </h2>

                <p class="ds_hero_lead">
                    Choosing an online degree should empower your career, not overwhelm you with confusing fee structures,
                    aggressive call-center pitches, or unrecognized universities. At DuraSetu (an EdZero initiative), we
                    combine data-driven university comparison across 25+ objective parameters, free 1-on-1 Google Meet
                    academic counseling, and end-to-end post-admission handholding. Most importantly, we work strictly for
                    students—never as commercial sales agents for universities—and guide you to complete 100% of your
                    admission and fee payments directly on the official university portal.
                </p>

                <div class="ds_hero_btns">
                    <a href="<?php echo e(url('universities')); ?>" class="ds_btn_primary">
                        <span>Compare Accredited Programs Now</span>
                        <i class="ri-arrow-right-line"></i>
                    </a>
                    <a href="<?php echo e(url('contact')); ?>" class="ds_btn_secondary">
                        <i class="ri-video-chat-line"></i>
                        <span>Book Free 1-on-1 Google Meet Counseling</span>
                    </a>
                </div>

                <!-- Mini Trust Strip -->
                <div class="ds_hero_trust_row">
                    <div class="ds_trust_item">
                        <i class="ri-checkbox-circle-fill"></i>
                        <span>50+ UGC-DEB Universities</span>
                    </div>
                    <div class="ds_trust_item">
                        <i class="ri-checkbox-circle-fill"></i>
                        <span>100% Direct Portal Payment</span>
                    </div>
                    <div class="ds_trust_item">
                        <i class="ri-checkbox-circle-fill"></i>
                        <span>Zero Commission Pressure</span>
                    </div>
                    <div class="ds_trust_item">
                        <i class="ri-checkbox-circle-fill"></i>
                        <span>Post-Admission Handholding</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. OUR STORY SECTION (FIXED COLLAGE & ATTRACTIVE MAGAZINE LAYOUT) -->
        <section class="ds_story_section">
            <div class="container">
                <div class="row align-items-center cs_gap_y_40">
                    <!-- Left Column: Fixed & Beautiful Floating Collage -->
                    <div class="col-lg-5" data-aos="fade-up">
                        <div class="ds_story_collage">
                            <!-- Main Image -->
                            <div class="ds_story_main_img">
                                <img src="<?php echo e(dura_path($ab['image1'] ?? 'assets/img/about-one.jpg')); ?>"
                                    alt="Students collaborating and studying online degrees">
                            </div>
                            <!-- Secondary Overlapping Image -->
                            <div class="ds_story_sub_img">
                                <img src="<?php echo e(dura_path($ab['image2'] ?? 'assets/img/about-two.jpg')); ?>"
                                    alt="Online tutor providing one-on-one video mentorship">
                            </div>
                            <!-- Experience Float Card -->
                            <div class="ds_story_exp_badge">
                                <div class="ds_exp_icon">
                                    <i class="ri-award-fill"></i>
                                </div>
                                <div>
                                    <div class="ds_exp_num"><?= htmlspecialchars($ab['exp_number'] ?: '5+'); ?></div>
                                    <div class="ds_exp_lbl">
                                        <?= htmlspecialchars($ab['exp_label'] ?: 'Years Counseling Expertise'); ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Verified Float Tag -->
                            <div class="ds_story_verified_tag">
                                <i class="ri-verified-badge-fill"></i>
                                <span>100% Student-First Advisory</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Formatted Story Content -->
                    <div class="col-lg-7" data-aos="fade-left">
                        <div class="ds_story_content">
                            <span class="ds_pill">
                                <i class="ri-compass-3-line"></i>
                                <span>Our Story</span>
                            </span>

                            <h2 class="ds_story_title">
                                Our Story — The Meaning of 'DuraSetu' &amp; Why We Built It</span>
                            </h2>

                            <p class="ds_story_lead">
                                Why We Built DuraSetu: From Firsthand Online MBA Experience to <span>India's Student-First
                                    Advisory Portal <br>
                                    The name <strong>DuraSetu</strong> comes from two foundational words:
                                    <strong>'Dura'</strong> (representing Distance and Online learning) and
                                    <strong>'Setu'</strong> (meaning a Bridge). We built DuraSetu under our parent education
                                    initiative, <strong>EdZero</strong>, to act as an honest, transparent bridge between
                                    ambitious learners across India and accredited universities offering Online and Open
                                    &amp;
                                    Distance Learning (ODL) programs.
                            </p>

                            <a href="<?php echo e(url('universities')); ?>" class="ds_btn_primary">
                                <span>Explore &amp; Compare Universities</span>
                                <i class="ri-arrow-right-line"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="ds_story_content">
                            <!-- Founder Firsthand Experience Highlight Box -->
                            <div class="ds_story_callout">
                                <i class="ri-double-quotes-l ds_callout_icon"></i>
                                <p>
                                    DuraSetu was born out of personal experience. When our founder, <strong>Arpan
                                        Sangam</strong>, pursued and completed his own Online MBA in India, he experienced
                                    the exact challenges that thousands of working professionals and fresh graduates face
                                    every single day. Students searching for an Online MBA, MCA, BBA, BCA, or DBA are often
                                    bombarded by dozens of tele-calling agencies pushing whichever college pays the highest
                                    commission—while hiding crucial realities about Learning Management System (LMS)
                                    quality, semester exam rules, hidden charges, and degree validity.
                                </p>
                            </div>

                            <p class="ds_story_footer_text">
                                Having walked the path as an online learner himself, Arpan founded <a
                                    href="https://durasetu.com/" class="text-primary">DuraSetu</a> with one clear
                                rule: <strong>put the student in 100% control</strong>. We do not partner with or favor any
                                university. Instead, we lay out verified facts side by side, walk you through real pros and
                                cons over live video counseling, and stand by you until you pay your fees directly on your
                                chosen university's official website.
                            </p>

                            <!-- Quick Trust Highlights -->
                            <div class="ds_story_features">
                                <div class="ds_story_feat_item">
                                    <i class="ri-checkbox-circle-fill"></i>
                                    <span>Zero Sales Telecalling</span>
                                </div>
                                <div class="ds_story_feat_item">
                                    <i class="ri-checkbox-circle-fill"></i>
                                    <span>100% Direct Portal Payment</span>
                                </div>
                                <div class="ds_story_feat_item">
                                    <i class="ri-checkbox-circle-fill"></i>
                                    <span>Free Google Meet Counseling</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. OUR CORE 3-PILLAR STUDENT EMPOWERMENT FRAMEWORK -->
        <section class="ds_pillars_section">
            <div class="container">
                <div class="ds_pillars_container" data-aos="fade-up">
                    <div class="text-center mb-5">
                        <span class="ds_pill"
                            style="background: rgba(255,255,255,0.1); border-color: rgba(252,149,2,0.4); color: #fc9502;">
                            <i class="ri-shield-star-line"></i>
                            <span>Our Core 3-Pillar Student Empowerment Framework</span>
                        </span>
                        <h2 class="text-white cs_fs_36 mb-2">
                            How DuraSetu Simplifies Your Online Degree Journey: <span class="ds_accent_txt">Compare, Counsel
                                &amp; Complete Support</span>
                        </h2>
                    </div>

                    <div class="row g-4">
                        <!-- Pillar 1 -->
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="50">
                            <div class="ds_pillar_card">
                                <div class="ds_pillar_header">
                                    <div class="ds_pillar_icon">
                                        <i class="ri-scales-3-line"></i>
                                    </div>
                                    <span class="ds_pillar_num">01</span>
                                </div>
                                <h3 class="ds_pillar_title">1. Compare (Data-Driven Comparison)</h3>
                                <div class="ds_pillar_delivers">
                                    Evaluate 50+ UGC-DEB entitled universities &amp; 100+ programs across 25+ factors
                                </div>
                                <p class="ds_pillar_desc">
                                    Compare NAAC grades, NIRF ranks, semester fees, EMI plans, LMS quality, exam patterns,
                                    and career ROI side by side.
                                </p>
                                <a href="<?php echo e(url('universities')); ?>" class="ds_pillar_link">
                                    <span>Compare Options</span>
                                    <i class="ri-arrow-right-line"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Pillar 2 -->
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                            <div class="ds_pillar_card">
                                <div class="ds_pillar_header">
                                    <div class="ds_pillar_icon">
                                        <i class="ri-video-chat-line"></i>
                                    </div>
                                    <span class="ds_pillar_num">02</span>
                                </div>
                                <h3 class="ds_pillar_title">2. Counsel (1-on-1 Video Mentoring)</h3>
                                <div class="ds_pillar_delivers">
                                    Unbiased live Google Meet sessions &amp; transparent YouTube program reviews
                                </div>
                                <p class="ds_pillar_desc">
                                    Speak with experienced academic counselors—not commission-driven telemarketers—who share
                                    honest pros and cons tailored to your budget.
                                </p>
                                <a href="<?php echo e(url('contact')); ?>" class="ds_pillar_link">
                                    <span>Talk to an Expert</span>
                                    <i class="ri-arrow-right-line"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Pillar 3 -->
                        <div class="col-lg-4 col-md-12" data-aos="fade-up" data-aos-delay="150">
                            <div class="ds_pillar_card">
                                <div class="ds_pillar_header">
                                    <div class="ds_pillar_icon">
                                        <i class="ri-shield-check-line"></i>
                                    </div>
                                    <span class="ds_pillar_num">03</span>
                                </div>
                                <h3 class="ds_pillar_title">3. Complete Support (Direct &amp; Post-Admission)</h3>
                                <div class="ds_pillar_delivers">
                                    100% direct university portal payment + support until graduation
                                </div>
                                <p class="ds_pillar_desc">
                                    We verify your documents, guide you to pay directly on the official university website,
                                    and track your LMS, assignments, and exam alerts.
                                </p>
                                <a href="<?php echo e(url('contact')); ?>" class="ds_pillar_link">
                                    <span>Get Support</span>
                                    <i class="ri-arrow-right-line"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. OUR MISSION & VISION -->
        <section class="ds_mv_section">
            <div class="container">
                <div class="text-center mb-5" data-aos="fade-up">
                    <span class="ds_pill">
                        <i class="ri-flag-2-line"></i>
                        <span>Our Mission &amp; Vision</span>
                    </span>
                    <h2 class="ds_story_title mb-0">Our Mission & Vision</h2>
                    <p class="cs_fs_18">
                        Our Purpose: Making Accredited Higher Education <span>Transparent, Safe &amp; Accessible</span>
                    </p>
                </div>
                <div class="row g-4">
                    <div class="col-md-6" data-aos="fade-right">
                        <div class="ds_mv_card ds_mission_card">
                            <div class="ds_mv_icon">
                                <i class="ri-flag-fill"></i>
                            </div>
                            <h3>Our Mission</h3>
                            <p>
                                To empower every learner in India—whether a working professional aiming for a leadership
                                promotion or a fresh graduate building foundational skills—with 100% unbiased university
                                comparisons, honest 1-on-1 mentorship, and safe, direct-to-university enrollment free from
                                spam or hidden consultancy fees.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6" data-aos="fade-left">
                        <div class="ds_mv_card ds_vision_card">
                            <div class="ds_mv_icon">
                                <i class="ri-eye-fill"></i>
                            </div>
                            <h3>Our Vision</h3>
                            <p>
                                To become India's most trusted, student-advocacy bridge for Online and Distance (ODL) higher
                                education under the EdZero umbrella, ensuring zero students fall prey to unrecognized
                                degrees, fake admission portals, or mismatched academic programs.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 5. VERIFICATION & AUTHORITY STANDARDS (COUNTER STRIP) -->
        <section class="ds_counter_strip" data-aos="fade-up">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="ds_pill"
                        style="background: rgba(255,255,255,0.08); border-color: rgba(252,149,2,0.4); color: #fc9502;">
                        <i class="ri-verified-badge-line"></i>
                        <span>Our Verification &amp; Authority Standards</span>
                    </span>
                    <h2 class="text-white cs_fs_36">
                        Verified Numbers That Reflect Our <span class="ds_accent_txt">Commitment to Students</span>
                    </h2>
                </div>
                <div class="ds_counter_grid">
                    <!-- 1 -->
                    <div class="ds_counter_box">
                        <div class="ds_counter_num">50+</div>
                        <div class="ds_counter_title">UGC-Approved Universities Listed</div>
                        <p class="ds_counter_desc">Every university listed on DuraSetu is cross-checked against official
                            UGC-DEB entitlement notifications.</p>
                    </div>
                    <!-- 2 -->
                    <div class="ds_counter_box">
                        <div class="ds_counter_num">100+</div>
                        <div class="ds_counter_title">Online &amp; ODL Programs Compared</div>
                        <p class="ds_counter_desc">Covering UG, PG, Doctoral (Online DBA), Executive MBA, Diplomas, and
                            Upskilling Certificates.</p>
                    </div>
                    <!-- 3 -->
                    <div class="ds_counter_box">
                        <div class="ds_counter_num">25+</div>
                        <div class="ds_counter_title">Objective Comparison Factors</div>
                        <p class="ds_counter_desc">Evaluate accreditations, total fees, EMI options, LMS demos, faculty
                            credentials, and placement cells.</p>
                    </div>
                    <!-- 4 -->
                    <div class="ds_counter_box">
                        <div class="ds_counter_num">5+</div>
                        <div class="ds_counter_title">Years of Counseling Expertise</div>
                        <p class="ds_counter_desc">Practical academic mentoring grounded in real online learning and student
                            career outcomes.</p>
                    </div>
                    <!-- 5 -->
                    <div class="ds_counter_box">
                        <div class="ds_counter_num">100%</div>
                        <div class="ds_counter_title">Free &amp; Unbiased Guidance</div>
                        <p class="ds_counter_desc">Zero consultancy charges, zero hidden fees, and zero pressure to pick any
                            specific institution.</p>
                    </div>
                    <!-- 6 -->
                    <div class="ds_counter_box">
                        <div class="ds_counter_num">100%</div>
                        <div class="ds_counter_title">Direct University Fee Payment</div>
                        <p class="ds_counter_desc">Every single rupee of your application and tuition fee is paid directly
                            on the official university portal.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 6. WHY CHOOSE DURASETU (6-CARD GRID) -->
        <section class="ds_why_section">
            <div class="container">
                <div class="text-center mb-5" data-aos="fade-up">
                    <span class="ds_pill">
                        <i class="ri-shield-star-line"></i>
                        <span>Why Choose DuraSetu Over Conventional Admission Portals?</span>
                    </span>
                    <h2 class="cs_fs_36">
                        Why Smart Learners Trust DuraSetu Before <span>Enrolling in Any Online Degree</span>
                    </h2>
                </div>
                <div class="ds_why_grid">
                    <!-- Card 1 -->
                    <div class="ds_why_card" data-aos="fade-up" data-aos-delay="50">
                        <div class="ds_why_header">
                            <div class="ds_why_icon"><i class="ri-shield-cross-line"></i></div>
                            <p class="ds_why_title">1. Strictly Independent (No University Tie-Ups)</p>
                        </div>
                        <p class="ds_why_body">We do not act as a sales agent for any college. Our comparisons rank programs
                            purely on merit, ROI, and suitability for your career goals.</p>
                    </div>

                    <!-- Card 2 -->
                    <div class="ds_why_card" data-aos="fade-up" data-aos-delay="100">
                        <div class="ds_why_header">
                            <div class="ds_why_icon"><i class="ri-bank-card-line"></i></div>
                            <p class="ds_why_title">2. 100% Direct-to-University Fee Payment</p>
                        </div>
                        <p class="ds_why_body">We protect your hard-earned money. We never collect tuition fees in
                            third-party accounts—you pay directly on the official university portal.</p>
                    </div>

                    <!-- Card 3 -->
                    <div class="ds_why_card" data-aos="fade-up" data-aos-delay="150">
                        <div class="ds_why_header">
                            <div class="ds_why_icon"><i class="ri-phone-lock-line"></i></div>
                            <p class="ds_why_title">3. Zero Spam &amp; Zero Pushy Cold Calls</p>
                        </div>
                        <p class="ds_why_body">Your privacy comes first. We never sell your phone number to call centers;
                            you only speak with a mentor when you request a session.</p>
                    </div>

                    <!-- Card 4 -->
                    <div class="ds_why_card" data-aos="fade-up" data-aos-delay="200">
                        <div class="ds_why_header">
                            <div class="ds_why_icon"><i class="ri-video-line"></i></div>
                            <p class="ds_why_title">4. Honest Pros &amp; Cons via Google Meet &amp; YouTube</p>
                        </div>
                        <p class="ds_why_body">We show you inside the university LMS, explain exam proctoring rules, and
                            openly tell you who should—and should not—pick a program.</p>
                    </div>

                    <!-- Card 5 -->
                    <div class="ds_why_card" data-aos="fade-up" data-aos-delay="250">
                        <div class="ds_why_header">
                            <div class="ds_why_icon"><i class="ri-checkbox-circle-line"></i></div>
                            <p class="ds_why_title">5. Multi-Layer Regulatory Verification</p>
                        </div>
                        <p class="ds_why_body">We verify UGC-DEB entitlement, AICTE approval, NAAC A/A+/A++ grades, NIRF
                            rankings, and WES recognition before listing any program.</p>
                    </div>

                    <!-- Card 6 -->
                    <div class="ds_why_card" data-aos="fade-up" data-aos-delay="300">
                        <div class="ds_why_header">
                            <div class="ds_why_icon"><i class="ri-user-follow-line"></i></div>
                            <p class="ds_why_title">6. Post-Admission Handholding Beyond Enrollment</p>
                        </div>
                        <p class="ds_why_body">Our relationship doesn't end after admission. We stay connected for LMS
                            onboarding, assignment deadlines, exam form alerts, and career positioning.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 7. PROGRAMS & REGULATORY APPROVALS -->
        <section class="ds_prog_section">
            <div class="container">
                <div class="text-center mb-4" data-aos="fade-up">
                    <span class="ds_pill">
                        <i class="ri-book-read-line"></i>
                        <span>Programs &amp; Regulatory Approvals You Can Compare on DuraSetu</span>
                    </span>
                    <h2 class="cs_fs_36">
                        Comprehensive Coverage Across Online Degrees, <span>ODL Programs, Doctorates &amp;
                            Certifications</span>
                    </h2>
                </div>
                <p class="ds_prog_lead" data-aos="fade-up">
                    Whether you are upgrading your managerial credentials, pivoting into technology, or completing your
                    graduation alongside a full-time job, DuraSetu helps you compare accredited programs across every major
                    academic stream in India:
                </p>
                <div class="ds_prog_grid">
                    <!-- 1 -->
                    <div class="ds_prog_card" data-aos="fade-up" data-aos-delay="50">
                        <div class="ds_prog_header">
                            <div class="ds_prog_icon"><i class="ri-graduation-cap-line"></i></div>
                            <p class="ds_prog_title">Online Postgraduate (PG) Degrees</p>
                        </div>
                        <p>Online MBA (Finance, HR, Marketing, Data Science, Healthcare, Operations, IT, International
                            Business), Online MCA, M.Com, MA, and M.Sc.</p>
                    </div>

                    <!-- 2 -->
                    <div class="ds_prog_card" data-aos="fade-up" data-aos-delay="100">
                        <div class="ds_prog_header">
                            <div class="ds_prog_icon"><i class="ri-book-open-line"></i></div>
                            <p class="ds_prog_title">Online Undergraduate (UG) Degrees</p>
                        </div>
                        <p>Online BBA, Online BCA, Online B.Com, and Online BA designed for flexible learning alongside work
                            or competitive exam preparation.</p>
                    </div>

                    <!-- 3 -->
                    <div class="ds_prog_card" data-aos="fade-up" data-aos-delay="150">
                        <div class="ds_prog_header">
                            <div class="ds_prog_icon"><i class="ri-award-line"></i></div>
                            <p class="ds_prog_title">Doctoral &amp; Executive Programs</p>
                        </div>
                        <p>Online DBA (Doctor of Business Administration), Executive MBA for working professionals, and
                            leadership programmes.</p>
                    </div>

                    <!-- 4 -->
                    <div class="ds_prog_card" data-aos="fade-up" data-aos-delay="200">
                        <div class="ds_prog_header">
                            <div class="ds_prog_icon"><i class="ri-article-line"></i></div>
                            <p class="ds_prog_title">Distance (ODL), Diplomas &amp; Certificates</p>
                        </div>
                        <p>UGC-DEB recognized Open &amp; Distance Learning (ODL) degrees, PG Diplomas, and industry-aligned
                            upskilling certifications.</p>
                    </div>

                    <!-- 5 (Full width) -->
                    <div class="ds_prog_card ds_prog_card_full" data-aos="fade-up" data-aos-delay="250">
                        <div class="ds_prog_header">
                            <div class="ds_prog_icon"><i class="ri-verified-badge-line"></i></div>
                            <p class="ds_prog_title">Regulatory &amp; Quality Checks Covered</p>
                        </div>
                        <p>UGC-DEB Entitlement, AICTE Approval, NAAC Accreditation (A, A+, A++), NIRF Ranking, AIU
                            Equivalence, and WES Global Recognition.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 8. LEADERSHIP & ACADEMIC COUNSELING TEAM -->
        <section class="ds_team_section">
            <div class="container">
                <div class="text-center mb-5" data-aos="fade-up">
                    <span class="ds_pill">
                        <i class="ri-user-star-line"></i>
                        <span>Leadership &amp; Academic Counseling Team</span>
                    </span>
                    <h2 class="cs_fs_36">
                        Leadership & Academic Counseling Team <span>(Google E-E-A-T Trust Section)</span>
                    </h2>
                    <p class="cs_fs_18">
                        Meet the Vision Behind DuraSetu: Built by an Online Degree Graduate for Online Learners
                    </p>
                </div>
                <div class="row g-4">
                    <!-- Founder Card -->
                    <div class="col-lg-6" data-aos="fade-right">
                        <div class="ds_team_card">
                            <span class="ds_team_badge"><i class="ri-user-star-fill"></i> Founder &amp; Chief Mentor</span>
                            <h3 class="ds_team_name">Arpan Sangam — Founder &amp; Chief Mentor, DuraSetu &amp; EdZero</h3>
                            <p class="ds_team_bio">
                                An Online MBA graduate, educator, and EdTech entrepreneur, Arpan Sangam founded DuraSetu
                                (under EdZero) after experiencing the online higher education ecosystem firsthand as a
                                student. Recognizing how difficult it was for learners to get unbiased answers about
                                syllabus rigor, LMS usability, exam flexibility, and real career outcomes, he built DuraSetu
                                to replace sales-driven counseling with transparent, research-backed mentorship. Through
                                DuraSetu's comparison portal, 1-on-1 mentoring, and educational YouTube breakdowns, Arpan
                                helps thousands of students make confident, regret-free degree decisions.
                            </p>
                        </div>
                    </div>

                    <!-- Counseling Team Card -->
                    <div class="col-lg-6" data-aos="fade-left">
                        <div class="ds_team_card">
                            <span class="ds_team_badge"><i class="ri-team-fill"></i> Mentorship &amp; Advisory</span>
                            <h3 class="ds_team_name">Our Certified Academic Counseling &amp; Student Support Team</h3>
                            <p class="ds_team_bio">
                                Behind DuraSetu is a dedicated team of academic counselors and student mentors with 5+ years
                                of specialized experience in Indian online and distance higher education. Unlike traditional
                                admission agents, our counselors are trained to evaluate your academic background, career
                                timeline, and financial comfort first—helping you compare all eligible universities
                                objectively, verify scholarship or no-cost EMI options, and complete your admission safely
                                on the university's official portal.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 9. HOW DURASETU WORKS (4-STEP PROCESS) & DISCLAIMER -->
        <section class="ds_steps_section">
            <div class="container">
                <div class="text-center mb-5" data-aos="fade-up">
                    <span class="ds_pill">
                        <i class="ri-route-line"></i>
                        <span>How DuraSetu Works</span>
                    </span>
                    <h2 class="cs_fs_36">
                        Your 4-Step Path to a Safe, <span>Verified Online Degree Admission</span>
                    </h2>
                </div>
                <!-- <div class="row g-4">
                    <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="50">
                        <div class="ds_step_card">
                            <div class="ds_step_num">01</div>
                            <h3 class="ds_step_title">Step 1 — Compare Universities &amp; Programs</h3>
                            <p class="ds_step_desc">Filter and compare UGC-DEB approved universities side by side on fees,
                                approvals, LMS, and specializations.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="ds_step_card">
                            <div class="ds_step_num">02</div>
                            <h3 class="ds_step_title">Step 2 — Book a Free 1-on-1 Session</h3>
                            <p class="ds_step_desc">Discuss your career goals and budget with our academic mentors to
                                shortlist the right university with zero sales pressure.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="150">
                        <div class="ds_step_card">
                            <div class="ds_step_num">03</div>
                            <h3 class="ds_step_title">Step 3 — Verify &amp; Pay Directly</h3>
                            <p class="ds_step_desc">We guide you through document verification and ensure you pay 100% of
                                your admission fees directly on the official university website.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="ds_step_card">
                            <div class="ds_step_num">04</div>
                            <h3 class="ds_step_title">Step 4 — Post-Admission Support</h3>
                            <p class="ds_step_desc">Receive ongoing reminders and guidance for LMS login, assignment
                                submissions, semester exams, and career readiness.</p>
                        </div>
                    </div>
                </div> -->


                <div class="cs_work_process_section cs_type_1 cs_section_padding bg-none pt-0">
                    <div class="container">
                        <div class="cs_work_process_steps">
                            <!-- Step 1 -->
                            <div class="cs_work_step_1 cs_step_theme_blue">
                                <span class="cs_work_step_number cs_center cs_fs_24 cs_semibold">01</span>
                                <div class="card-border-blue">
                                    <div class="cs_work_step_card">
                                        <div class="cs_step_icon_badge">
                                            <i class="ri-search-line"></i>
                                        </div>
                                        <p class="cs_work_step_title cs_fs_18 cs_semibold">Step 1 — Compare Universities & Programs
                                        </p>
                                        <p class="cs_work_step_text cs_fs_14">Filter and compare UGC-DEB approved
                                            universities side by side on fees,
                                            approvals, LMS, and specializations.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <div class="cs_work_step_1 cs_step_theme_orange">
                                <span class="cs_work_step_number cs_center cs_fs_24 cs_semibold">02</span>
                                <div class="card-border-yellow">
                                    <div class="cs_work_step_card">
                                        <div class="cs_step_icon_badge">
                                            <i class="ri-scales-3-line"></i>
                                        </div>
                                        <p class="cs_work_step_title cs_semibold">Step 2 — Book a Free 1-on-1 Session</p>
                                        <p class="cs_work_step_text cs_fs_14">Discuss your career goals and budget with our
                                            academic mentors to
                                            shortlist the right university with zero sales pressure.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div class="cs_work_step_1 cs_step_theme_blue">
                                <span class="cs_work_step_number cs_center cs_fs_24 cs_semibold">03</span>
                                <div class="card-border-blue">
                                    <div class="cs_work_step_card">
                                        <div class="cs_step_icon_badge">
                                            <i class="ri-file-check-line"></i>
                                        </div>
                                        <p class="cs_work_step_title cs_semibold">Step 3 — Verify &amp; Pay Directly</p>
                                        <p class="cs_work_step_text cs_fs_14">We guide you through document verification and
                                            ensure you pay 100% of
                                            your admission fees directly on the official university website.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 4 -->
                            <div class="cs_work_step_1 cs_step_theme_orange">
                                <span class="cs_work_step_number cs_center cs_fs_24 cs_semibold">04</span>
                                <div class="card-border-yellow">
                                    <div class="cs_work_step_card">
                                        <div class="cs_step_icon_badge">
                                            <i class="ri-file-check-line"></i>
                                        </div>
                                        <p class="cs_work_step_title cs_semibold">Step 4 — Post-Admission Support</p>
                                        <p class="cs_work_step_text cs_fs_14">Receive ongoing reminders and guidance for LMS
                                            login, assignment
                                            submissions, semester exams, and career readiness.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
</div>

        <!-- Official Independence & Direct-Payment Disclaimer Box -->
        <div class="ds_disclaimer_box" data-aos="fade-up" data-aos-delay="250">
            <div class="ds_disclaimer_title">
                <i class="ri-information-line"></i>
                <span>Official Independence &amp; Direct-Payment Disclaimer</span>
            </div>
            <p class="ds_disclaimer_text">
                DuraSetu (operated by EdZero) is an independent student information, comparison, and academic
                counseling platform. We do NOT claim commercial partnership or affiliation with any university
                listed on our portal, nor do we collect tuition fees on behalf of any institution. All university
                names, logos, accreditations, and program details are presented strictly for informational and
                comparative purposes to empower students. Students are guided to verify credentials and complete all
                application and tuition fee payments 100% directly on the respective university's official website.
            </p>
        </div>
        </div>
        </section>


        <!-- 10. PRE-EXISTING FAQ SECTION -->
        <section class="cs_faq_section cs_section_padding">
            <div class="container">
                <div class="cs_section_heading_style_1 cs_center_column text-center mb-5" data-aos="fade-up">
                    <h2 class="cs_pop_title cs_fs_42 cs_medium mb-2">
                        Frequently Asked <span>Questions</span>
                    </h2>
                    <p class="cs_section_subtitle mb-0">
                        Find answers to common questions about universities, courses, fees, and admissions.
                    </p>
                </div>
                <div class="cs_faq_wrap">
                    <!-- Left Side Card -->
                    <div class="cs_faq_media_col" data-aos="fade-right">
                        <div class="cs_faq_left_wrapper">
                            <div class="cs_help_card">
                                <div class="cs_help_thumbnail">
                                    <img src="<?php echo e(asset('assets/img/help-desk-1.jpg')); ?>" alt="DuraSetu student guidance">
                                    <span class="cs_help_doodle_burst" aria-hidden="true">
                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                            <path d="M5 23L1 27M14 15L14 8M21 19L27 15" stroke="#f59e0b" stroke-width="2.5"
                                                stroke-linecap="round" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="cs_help_content">
                                    <h3 class="cs_help_title">
                                        Need Help <span>Choosing?</span>
                                    </h3>

                                    <p class="cs_help_text">
                                        Not sure which university or course is right for you? Our experts can help you
                                        compare your options and make a confident decision.
                                    </p>
                                    <a href="tel:+<?php echo e(setting('phone')); ?>" class="cs_help_expert_btn">
                                        <i class="ri-user-line"></i>
                                        <span>Talk to an Expert</span>
                                        <i class="ri-arrow-right-line"></i>
                                    </a>
                                </div>
                                <div class="cs_help_corner_accent" aria-hidden="true"></div>
                            </div>
                            <div class="cs_help_dots_grid" aria-hidden="true"></div>
                        </div>
                    </div>

                    <!-- Right Side Accordion -->
                    <div class="cs_accordians_style_1 position-relative z-1" data-aos="fade-left">
                        <?php foreach (dura_get_faqs('about') as $fi => $faq): ?>
                        <div class="cs_accordian<?= $fi === 0 ? ' active' : ''; ?>">
                            <div class="cs_accordian_head">
                                <h3 class="cs_accordian_title mb-0"><?= htmlspecialchars($faq['question']); ?></h3>
                                <span class="cs_accordian_toggle" aria-hidden="true">
                                    <i class="ri-add-line cs_toggle_plus"></i>
                                    <i class="ri-subtract-line cs_toggle_minus"></i>
                                </span>
                            </div>
                            <div class="cs_accordian_body"><?= htmlspecialchars($faq['answer']); ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                </div>

            </div>
        </section>

        <!-- 11. PRE-EXISTING UNIVERSITIES SECTION -->
        <section class="cs_partners_section durasetu_universities_section" data-aos="fade-up">
            <div class="container">
                <div class="cs_partners_wrap">
                    <h2 class="cs_partners_title cs_fs_20 cs_semibold mb-0">
                        Top Online Universities
                    </h2>
                    <div class="cs_partners_marquee swiper" data-marquee="1" data-autoplay="1" data-speed="6000"
                        data-slides-per-view="responsive" data-gap="24" data-xxlg-gap="65" data-xsm-slides="3"
                        data-sm-slides="3" data-smd-slides="3" data-md-slides="4" data-lg-slides="5" data-xlg-slides="6"
                        data-xxlg-slides="6">
                        <div class="swiper-wrapper cs_partners_track">
                            <?php foreach ($universities as $university): ?>
                            <div class="swiper-slide">
                                <div class="cs_partner_logo durasetu_university_logo">
                                    <img src="<?= htmlspecialchars($university['logo']); ?>"
                                        alt="<?= htmlspecialchars($university['name']); ?>" loading="lazy">
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

</main><?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard\dura-setu-laravel\resources\views/site/about.blade.php ENDPATH**/ ?>