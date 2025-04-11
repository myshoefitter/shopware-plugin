# mySHOEFITTER Extension for Shopware 6

This guide provides step-by-step instructions for installing the mySHOEFITTER plugin in both Shopware 5 and Shopware 6, with methods for both admin dashboard installation and manual installation.

## Shopware 6 Installation

### Method 1: Admin Dashboard Installation

#### Step 1: Download the Plugin

Download the latest version of the mySHOEFITTER plugin for Shopware 6 (.zip file).

#### Step 2: Upload via Admin Dashboard

1. Log in to your Shopware 6 Admin Panel
2. Navigate to **Extensions** → **My Extensions**
3. Click on the **Upload Extension** button in the top right corner
4. A file dialog will appear. Select the downloaded `.zip` file
5. Click **Upload** and wait for the upload to complete

#### Step 3: Install and Activate

1. After the upload is successful, you will see the mySHOEFITTER plugin in your extensions list
2. Click the **...** (three dots) menu next to the plugin and select **Install**
3. Once installed, click the slider button to **Activate** the plugin
4. The system may prompt you to clear the cache. If so, click **Clear Cache and Activate**

#### Step 4: Configure the Plugin

1. Click on the **...** (three dots) menu again and select **Config**

2. Configure the following settings:
   - **Enable mySHOEFITTER**: Set to "Yes" to enable the plugin
   - **Script URL**: Verify the script URL (default: https://js.myshoefitter.com/v1/script.js)

3. Click **Save** to apply your settings

#### Step 5: Verify Installation

1. Visit your shop's frontend
2. Open your browser's developer tools (F12 or right-click → Inspect)
3. Check the HTML source at the bottom of the page
4. Verify that the mySHOEFITTER script is present just before the closing `</body>` tag

### Method 2: Manual Installation

#### Step 1: Prepare the Plugin

1. Download the latest mySHOEFITTER plugin ZIP file
2. Extract the ZIP file on your local machine
3. Ensure the directory structure matches:
   ```
   MyShoeFitter/
   ├── composer.json
   └── src/
       ├── MyShoeFitter.php
       ├── Resources/
       │   ├── config/
       │   │   ├── config.xml
       │   │   └── services.xml
       │   └── views/
       │       └── storefront/
       │           └── base.html.twig
       └── Service/
           └── ScriptInjectionService.php
   ```

#### Step 2: Upload to Server

1. Connect to your server via FTP or SSH
2. Navigate to the Shopware plugins directory:
   ```
   /path/to/shopware/custom/plugins/
   ```
3. Upload the entire `MyShoeFitter` folder to this directory

#### Step 3: Install via Command Line

1. SSH into your server
2. Navigate to your Shopware root directory
3. Run the following commands:

   ```bash
   # Register the plugin
   bin/console plugin:refresh

   # Install the plugin
   bin/console plugin:install --activate MyShoeFitter

   # Clear the cache
   bin/console cache:clear
   ```

#### Step 4: Configure the Plugin

1. Log in to your Shopware 6 Admin Panel
2. Navigate to **Extensions** → **My Extensions**
3. Find the MyShoeFitter plugin and click on the **...** (three dots) menu
4. Select **Config** and configure the plugin as described in Method 1, Step 4

#### Step 5: Verify Installation

Follow the verification steps from Method 1, Step 5

## Troubleshooting

### Common Issues with Manual Installation

#### Shopware 6

1. **Permission Issues**:
   - Ensure the plugin directory and files have the correct permissions (typically 755 for directories and 644 for files)
   - The web server user (e.g., www-data) needs read access to all plugin files

2. **Command Line Errors**:
   - If you get "Command not found" errors, ensure you're in the correct Shopware root directory
   - Make sure the console command is executable: `chmod +x bin/console`

3. **Directory Structure**:
   - Double-check that you've placed the plugin in the correct location (`custom/plugins/MyShoeFitter`)
   - Verify the plugin's internal directory structure matches what's expected

### Troubleshooting Dashboard Installation

#### Shopware 6

If you encounter issues during dashboard installation:

1. Check that your Shopware version is 6.0.0 or higher
2. Ensure you have the necessary permissions to install plugins
3. Clear the cache manually:
   - Go to **Settings** → **Cache/Performance** → **Clear Cache**
4. Check the Shopware logs at `var/log/` for any error messages

## Manual Configuration File Editing

In some cases, you might need to manually edit configuration files after installation:

### Shopware 6

If you need to manually adjust the plugin configuration:

1. Navigate to the Shopware configuration directory: `/path/to/shopware/config/`
2. Look for a file named similarly to `config_ENVIRONMENT_SHOPID.json` (where ENVIRONMENT is your environment and SHOPID is your shop ID)
3. Edit this file and find the `MyShoeFitter.config` section:
   ```json
   {
     "MyShoeFitter.config": {
       "enabled": true,
       "scriptUrl": "https://js.myshoefitter.com/v1/script.js"
     }
   }
   ```
4. Make your changes and save the file
5. Clear the cache:
   ```bash
   bin/console cache:clear
   ```

## Support

If you need further assistance, please contact our support team:

- Email: info@myshoefitter.com
- Website: https://en.myshoefitter.com/kontakt
