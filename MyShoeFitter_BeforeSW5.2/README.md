# mySHOEFITTER Extension for Shopware 5

This guide provides step-by-step instructions for installing the mySHOEFITTER plugin in both Shopware 5 and Shopware 6, with methods for both admin dashboard installation and manual installation.

## Shopware 5 Installation

### Method 1: Admin Dashboard Installation

#### Step 1: Download the Plugin

Download the latest version of the mySHOEFITTER plugin for Shopware 5 (.zip file).

#### Step 2: Upload via Admin Dashboard

1. Log in to your Shopware 5 Admin Panel
2. Navigate to **Configuration** → **Plugin Manager**
3. Click on the **Upload Plugin** button in the top right
4. Select the downloaded `.zip` file
5. Click **Upload Plugin** and wait for the upload to complete

#### Step 3: Install and Activate

1. After the upload is successful, go to the **Installed** tab
2. Find "mySHOEFITTER" in the list
3. Click **Install** next to the plugin
4. After installation completes, click **Activate** to enable the plugin
5. A prompt may appear to clear the cache. Click **Yes** to proceed

#### Step 4: Configure the Plugin

1. With the plugin activated, click on the **Configuration** icon (gear symbol)

2. Configure the following settings:
   - **Enable mySHOEFITTER**: Set to "Yes" to enable the plugin
   - **Script URL**: Verify the script URL (default: https://js.myshoefitter.com/v1/script.js)

3. Click **Save** to apply your settings

#### Step 5: Verify Installation

1. Visit your shop's frontend
2. View the page source (right-click → View Page Source)
3. Scroll to the bottom of the page
4. Verify that the mySHOEFITTER script is present just before the closing `</body>` tag

### Method 2: Manual Installation

#### Step 1: Prepare the Plugin

1. Download the latest mySHOEFITTER plugin ZIP file
2. Extract the ZIP file on your local machine
3. Ensure the directory structure matches:
   ```
   MyShoeFitter/
   ├── Bootstrap.php
   ├── plugin.xml
   └── Resources/
       ├── config.xml
       └── views/
           └── frontend/
               └── index/
                   └── footer.tpl
   ```

#### Step 2: Upload to Server

1. Connect to your server via FTP or SSH
2. Navigate to the Shopware 5 plugins directory:
   ```
   /path/to/shopware/custom/plugins/Frontend/
   ```
3. Upload the entire `MyShoeFitter` folder to this directory

#### Step 3: Install via Command Line

1. SSH into your server
2. Navigate to your Shopware root directory
3. Run the following commands:

   ```bash
   # Clear cache
   php bin/console sw:cache:clear

   # Refresh plugin list
   php bin/console sw:plugin:refresh

   # Install the plugin
   php bin/console sw:plugin:install MyShoeFitter

   # Activate the plugin
   php bin/console sw:plugin:activate MyShoeFitter

   # Clear cache again
   php bin/console sw:cache:clear
   ```

#### Step 4: Configure the Plugin

1. Log in to your Shopware 5 Admin Panel
2. Navigate to **Configuration** → **Plugin Manager** → **Installed**
3. Find the MyShoeFitter plugin and click on the **Configuration** icon (gear symbol)
4. Configure the plugin as described in Method 1, Step 4

#### Step 5: Verify Installation

Follow the verification steps from Method 1, Step 5

## Troubleshooting

### Common Issues with Manual Installation

#### Shopware 5

1. **Permission Issues**:
   - Ensure the plugin directory has the same owner and permissions as other Shopware files
   - Typically 755 for directories and 644 for files

2. **Command Line Errors**:
   - Error "Plugin not found": Check that the plugin is in the correct directory (`custom/plugins/Frontend/MyShoeFitter`)
   - Make sure you're running commands from the Shopware root directory

3. **Class Not Found Errors**:
   - If you see class loading errors, check that the plugin follows the correct namespace and directory structure
   - Try deleting the `/var/cache` directory manually

### Troubleshooting Dashboard Installation

### Shopware 5

If you encounter issues during installation:

1. Check that your Shopware version is 5.2.0 or higher
2. Ensure you have the necessary permissions to install plugins
3. Try clearing the cache:
   - Go to **Configuration** → **Cache/Performance** → **Clear shop cache**
4. Check the Shopware logs at **Configuration** → **Logfile** for any error messages

## Manual Configuration File Editing

In some cases, you might need to manually edit configuration files after installation:

### Shopware 5

For Shopware 5, configuration is stored in the database, but you can still manually set it:

1. Connect to your MySQL database
2. Find the configuration table:
   ```sql
   SELECT * FROM s_core_config_elements WHERE name LIKE '%MyShoeFitter%';
   ```
3. To update a value:
   ```sql
   UPDATE s_core_config_values 
   SET value = 's:YOUR_VALUE' 
   WHERE element_id = (SELECT id FROM s_core_config_elements WHERE name = 'SETTING_NAME');
   ```
4. Clear the cache after making changes

## Support

If you need further assistance, please contact our support team:

- Email: info@myshoefitter.com
- Website: https://en.myshoefitter.com/kontakt
