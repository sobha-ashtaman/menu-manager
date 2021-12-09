# Laravel Menu Manager - Manage your website menu
Laravel menu manager is a package which helps you to manage your websites menu.

# Installation
##### Install the package.
`composer require devsobsud/menu-manager`

##### Publish the configuration file
`php artisan vendor:publish --provider="DevSobSud\MenuManager\MenuManagerServiceProvider"`

##### Run migration
`php artisan migrate`

# Configuration
Open the configuration file `config/menu.php`

You can change admin panel prefix and middleware from here. 
Also you can specify the positions of the menu. Eg: Main menu, Footer menu, Right panel menu etc.

# Usage
Open `{domain}/{prefix}/menu` link from the browser and start adding menu in your desired position.
