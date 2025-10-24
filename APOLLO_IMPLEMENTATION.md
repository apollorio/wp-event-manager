# Apollo Core Integration - WP Event Manager

## Overview
This document describes the implementation of the Apollo Core integration for WP Event Manager, specifically addressing the Single Event Page display and Portal/Dashboard functionality for DJs and Locals.

## Problem Statement
The WP Event Manager plugin was missing:
1. DJ and Local information display on Single Event Pages
2. Dashboard templates for managing DJs and Locals through the portal

## Solution Implemented

### 1. Single Event Page - DJ Display
**File Created:** `/templates/dj/content-single-event_listing-dj.php`

**Features:**
- Displays DJs associated with an event
- Shows DJ thumbnail/logo
- Displays DJ name with link to DJ profile
- Shows DJ description
- Displays DJ social media links (Website, Facebook, Instagram, Twitter, YouTube)
- Supports multiple DJs per event
- Includes action hooks for extensibility:
  - `single_event_listing_dj_start`
  - `single_event_listing_dj_description_before`
  - `single_event_listing_dj_description_after`
  - `single_event_listing_dj_social_start`
  - `single_event_listing_dj_single_social_end`
  - `single_event_listing_dj_action_start`
  - `single_event_listing_dj_action_end`
  - `single_event_listing_dj_end`

**Integration:**
The template is automatically loaded on single event pages when:
- The `enable_event_dj` option is enabled
- The event has associated DJs (via `_event_dj_ids` meta field)

**Usage:**
```php
// The template uses these functions:
has_event_dj_ids()  // Check if event has DJs
get_event_dj_ids()  // Get array of DJ IDs
```

### 2. Single Event Page - Local Display
**File Created:** `/templates/local/content-single-event_listing-local.php`

**Features:**
- Displays Local/Venue information associated with an event
- Shows Local thumbnail/logo
- Displays Local name with link to Local profile
- Shows Local description
- Displays Local contact information (Address, Phone, Email)
- Displays Local social media links (Website, Facebook, Instagram, Twitter)
- Includes action hooks for extensibility:
  - `single_event_listing_local_start`
  - `single_event_listing_local_description_before`
  - `single_event_listing_local_description_after`
  - `single_event_listing_local_social_start`
  - `single_event_listing_local_single_social_end`
  - `single_event_listing_local_action_start`
  - `single_event_listing_local_action_end`
  - `single_event_listing_local_end`

**Integration:**
The template is automatically loaded on single event pages when:
- The `enable_event_local` option is enabled
- The event has an associated Local (via `_event_local_ids` meta field)

**Usage:**
```php
// The template uses these functions:
has_event_local_ids()  // Check if event has a Local
get_event_local_ids()  // Get Local ID
```

### 3. Modified File - Single Event Template
**File Modified:** `/templates/content-single-event_listing.php`

**Changes:**
Added template loading for DJ and Local sections after the Venue section (lines 543-562):

```php
//if DJ setting is enable then display DJ section on single event listing
if (get_option('enable_event_dj')) {
    get_event_manager_template(
        'content-single-event_listing-dj.php',
        array(),
        'wp-event-manager/dj',
        EVENT_MANAGER_PLUGIN_DIR . '/templates/dj'
   );
}
//if Local setting is enable then display Local section on single event listing
if (get_option('enable_event_local')) {
    get_event_manager_template(
        'content-single-event_listing-local.php',
        array(),
        'wp-event-manager/local',
        EVENT_MANAGER_PLUGIN_DIR . '/templates/local'
   );
}
```

### 4. DJ Dashboard Template
**File Created:** `/templates/dj/dj-dashboard.php`

**Features:**
- Lists all DJs belonging to the logged-in user
- Displays DJ thumbnail, name, and event count
- Shows DJ status (publish, pending, etc.)
- Provides action buttons:
  - **View** - Opens DJ profile page (for published DJs)
  - **Edit** - Opens DJ edit form
  - **Duplicate** - Creates a copy of the DJ
  - **Delete** - Removes the DJ (moves to trash)
- Includes "Add DJ" button linking to submission form
- Supports pagination for large DJ lists
- Includes action hooks:
  - `event_manager_dj_dashboard_before`
  - `event_manager_dj_dashboard_button_action_start`
  - `event_manager_dj_dashboard_button_action_end`
  - `event_manager_dj_dashboard_after`

**Usage:**
Display the DJ dashboard using the shortcode:
```
[dj_dashboard]
```

### 5. Local Dashboard Template
**File Created:** `/templates/local/local-dashboard.php`

**Features:**
- Lists all Locals/Venues belonging to the logged-in user
- Displays Local thumbnail, name, event count, and address
- Shows Local status (publish, pending, etc.)
- Provides action buttons:
  - **View** - Opens Local profile page (for published Locals)
  - **Edit** - Opens Local edit form
  - **Duplicate** - Creates a copy of the Local
  - **Delete** - Removes the Local (moves to trash)
- Includes "Add Local" button linking to submission form
- Supports pagination for large Local lists
- Includes action hooks:
  - `event_manager_local_dashboard_before`
  - `event_manager_local_dashboard_button_action_start`
  - `event_manager_local_dashboard_button_action_end`
  - `event_manager_local_dashboard_after`

**Usage:**
Display the Local dashboard using the shortcode:
```
[local_dashboard]
```

## Meta Fields Used

### DJ Meta Fields
- `_event_dj_ids` - Array of DJ post IDs associated with an event
- `_dj_website` - DJ website URL
- `_dj_facebook` - DJ Facebook profile URL
- `_dj_instagram` - DJ Instagram profile URL
- `_dj_twitter` - DJ Twitter profile URL
- `_dj_youtube` - DJ YouTube channel URL
- `_dj_email` - DJ contact email

### Local Meta Fields
- `_event_local_ids` - Local post ID associated with an event
- `_local_website` - Local website URL
- `_local_facebook` - Local Facebook page URL
- `_local_instagram` - Local Instagram profile URL
- `_local_twitter` - Local Twitter profile URL
- `_local_address` - Local physical address
- `_local_phone` - Local contact phone
- `_local_email` - Local contact email

## WordPress Functions Used

### Built-in Functions
- `get_post()` - Get post object
- `get_permalink()` - Get post URL
- `has_post_thumbnail()` - Check if post has featured image
- `get_the_post_thumbnail()` - Get post featured image HTML
- `get_post_meta()` - Get post meta value
- `wp_kses_post()` - Sanitize post content
- `esc_url()` - Escape URL
- `esc_html()` - Escape HTML
- `esc_attr()` - Escape HTML attribute

### WP Event Manager Functions
- `has_event_dj_ids()` - Check if event has DJs
- `get_event_dj_ids()` - Get DJ IDs for an event
- `has_event_local_ids()` - Check if event has a Local
- `get_event_local_ids()` - Get Local ID for an event
- `get_event_dj_count($dj_id)` - Get number of events for a DJ
- `get_event_local_count($local_id)` - Get number of events for a Local
- `event_manager_get_permalink()` - Get Event Manager page permalink
- `get_event_manager_template()` - Load Event Manager template

## Configuration Required

### WordPress Settings
To enable DJ and Local functionality, the following options must be set in WordPress:

1. **Enable DJs:**
   ```php
   update_option('enable_event_dj', 1);
   ```

2. **Enable Locals:**
   ```php
   update_option('enable_event_local', 1);
   ```

3. **Set DJ Submission Form Page:**
   ```php
   update_option('event_manager_submit_dj_form_page_id', $page_id);
   ```

4. **Set Local Submission Form Page:**
   ```php
   update_option('event_manager_submit_local_form_page_id', $page_id);
   ```

### Page Setup
Create WordPress pages with these shortcodes:

1. **DJ Dashboard Page:**
   ```
   [dj_dashboard]
   ```

2. **Local Dashboard Page:**
   ```
   [local_dashboard]
   ```

3. **Main Event Dashboard Page:**
   ```
   [event_dashboard]
   ```
   (This already includes DJ and Local management if configured)

## Testing Checklist

### Single Event Page Testing
- [ ] Create an event and associate a DJ
- [ ] View the single event page
- [ ] Verify DJ information displays correctly
- [ ] Check DJ image/logo displays
- [ ] Verify DJ social links work
- [ ] Create an event and associate a Local
- [ ] View the single event page
- [ ] Verify Local information displays correctly
- [ ] Check Local contact information displays

### Dashboard Testing
- [ ] Log in as a user with DJ capability
- [ ] Access DJ Dashboard page
- [ ] Create a new DJ
- [ ] View DJ in dashboard list
- [ ] Edit DJ information
- [ ] Duplicate a DJ
- [ ] Delete a DJ
- [ ] Log in as a user with Local capability
- [ ] Access Local Dashboard page
- [ ] Create a new Local
- [ ] View Local in dashboard list
- [ ] Edit Local information
- [ ] Duplicate a Local
- [ ] Delete a Local

## Files Modified/Created

### Created Files:
1. `/templates/dj/content-single-event_listing-dj.php` - DJ display on single event page
2. `/templates/local/content-single-event_listing-local.php` - Local display on single event page
3. `/templates/dj/dj-dashboard.php` - DJ management dashboard
4. `/templates/local/local-dashboard.php` - Local management dashboard

### Modified Files:
1. `/templates/content-single-event_listing.php` - Added DJ and Local template loading

## Compatibility

- **WordPress Version:** 6.8.2+
- **PHP Version:** 7.4+
- **WP Event Manager Version:** 3.2.2+

## Support for Extensibility

All templates include numerous action hooks that allow developers to:
- Add custom fields to DJ/Local displays
- Modify dashboard actions
- Add custom buttons or functionality
- Integrate with third-party plugins

Example:
```php
// Add custom content after DJ description
add_action('single_event_listing_dj_description_after', function($dj_id) {
    echo '<div class="custom-dj-info">';
    echo get_post_meta($dj_id, '_custom_field', true);
    echo '</div>';
});
```

## Troubleshooting

### DJ or Local section not showing on single event page
1. Check if `enable_event_dj` or `enable_event_local` option is enabled
2. Verify the event has associated DJs or Local (check `_event_dj_ids` or `_event_local_ids` meta)
3. Ensure DJ or Local post is published (not draft or trash)

### Dashboard not displaying
1. Verify user is logged in
2. Check if dashboard page has correct shortcode
3. Ensure user has permission to manage DJs/Locals
4. Check if submission form page is configured

### Missing images/thumbnails
1. Ensure DJ/Local has a featured image set
2. Check image file exists and is accessible
3. Verify WordPress media library is functioning correctly

## Future Enhancements

Potential improvements for future versions:
1. REST API endpoints for DJ and Local management
2. AJAX-powered dashboard for better performance
3. Bulk actions for managing multiple DJs/Locals
4. Search and filter functionality in dashboards
5. Statistics and analytics for DJs/Locals
6. Email notifications for DJ/Local-related events
7. Integration with calendar systems
8. Export/import functionality for DJs/Locals

## Version History

### Version 1.0.0 (2025-10-24)
- Initial implementation
- Added DJ display on single event pages
- Added Local display on single event pages
- Created DJ dashboard template
- Created Local dashboard template
- Modified single event template to load DJ/Local sections

## Credits

- Implementation: Apollo Core Integration Project
- Based on: WP Event Manager Plugin
- Developer: GitHub Copilot Agent
- Date: October 24, 2025

## License

This implementation follows the same license as WP Event Manager:
GNU General Public License v3.0
