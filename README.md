# Cron Zombies

**Contributors:** [Noah Stewart]  
**Tags:** cron, admin tools, wp-cron, cron manager  
**Requires at least:** 5.0  
**Tested up to:** 6.4  
**Requires PHP:** 7.4  
**Stable tag:** 1.0.0  
**License:** MIT  
**License URI:** https://opensource.org/licenses/MIT  

Manage and delete WordPress cron jobs directly from the admin dashboard. Easily kill lingering or "zombie" cron jobs and execute cron tasks manually.

---

## Description

Cron Zombies is a lightweight plugin that lists all WordPress cron jobs and provides an intuitive admin interface to manage and delete them.  

Sometimes, plugins register cron jobs that continue running even after the plugin is deactivated. This plugin helps you identify and delete those orphaned cron jobs, keeping your site running smoothly.

### Features:
- **View all registered cron jobs** in a sortable table.  
- **Bulk delete cron jobs** directly from the admin interface.  
- **Run cron jobs manually** with a simple button click.  
- **Check for "zombie" cron jobs** (orphaned jobs from inactive plugins).  
- **Secure actions** with nonce verification to prevent unauthorized actions.  
- **Translation ready** – .pot file included for easy localization.  

---

## Installation

### Automatic Installation
1. Log in to your WordPress admin panel.  
2. Navigate to **Plugins > Add New**.  
3. Search for "Cron Zombies".  
4. Click **Install Now** and then **Activate**.

### Manual Installation
1. Download the plugin ZIP file.  
2. Upload the `cron-zombies` folder to the `/wp-content/plugins/` directory.  
3. Activate the plugin through the 'Plugins' screen in WordPress.  
4. Go to **Tools > Cron Zombies** to manage cron jobs.

---

## Frequently Asked Questions

### 1. Why do cron jobs remain after deactivating plugins?  
WordPress cron jobs are stored in the database and are not automatically removed when a plugin is deactivated. This plugin allows you to manually delete these jobs.

### 2. Can I undo a deleted cron job?  
No, once a cron job is deleted, it cannot be restored. Please verify before deleting recurring jobs.

### 3. Is this plugin safe to use?  
Yes. The plugin uses WordPress nonces for all cron actions, ensuring safe and secure management of cron jobs.

---

## Screenshots

1. **View all cron jobs in a sortable table.**  
2. **Delete or run cron jobs directly from the admin dashboard.**  
3. **Bulk delete cron jobs.**  

---

## Changelog

### 1.0.0
- Initial release.  
- List and manage cron jobs from the admin panel.  

---

## Upgrade Notice

### 1.0.0
- First release – No upgrade required.  

---

## License
This plugin is licensed under the [MIT License](https://opensource.org/licenses/MIT).  
See the `license.txt` file for more details.  
