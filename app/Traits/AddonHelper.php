<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;

trait AddonHelper
{
    public function get_addons(): array
    {
        $dir = 'Modules';
        $directories = self::getDirectories($dir);
        $addons = [];
        foreach ($directories as $directory) {
            $sub_dirs = self::getDirectories('Modules/' . $directory);
            if (in_array('Addon', $sub_dirs)) {
                $addons[] = 'Modules/' . $directory;
            }
        }

        $array = [];
        foreach ($addons as $item) {
            $full_data = include($item . '/Addon/info.php');
            $array[] = [
                'addon_name' => $full_data['name'],
                'software_id' => $full_data['software_id'],
                'is_published' => $full_data['is_published'],
            ];
        }

        return $array;
    }

    public function getAddonAdminRoutes(): array
    {
        $dir = 'Modules';
        $directories = self::getDirectories($dir);
        $addons = [];
        foreach ($directories as $directory) {
            $sub_dirs = self::getDirectories('Modules/' . $directory);
            if (in_array('Addon', $sub_dirs)) {
                $addons[] = 'Modules/' . $directory;
            }
        }

        $fullData = [];
        foreach ($addons as $item) {
            if (file_exists(base_path($item . '/Addon/info.php')) && file_exists(base_path($item . '/Addon/admin_routes.php'))) {
                $info = include(base_path($item . '/Addon/info.php'));
                if ($info['is_published']) {
                    $fullData[] = include(base_path($item . '/Addon/admin_routes.php'));
                }
            }
        }

        return $fullData;
    }

    public function getPaymentPublishStatus(): int
    {
        $dir = 'Modules'; // Update the directory path to Modules/Gateways
        $directories = self::getDirectories($dir);

        $addons = [];
        foreach ($directories as $directory) {
            $subDirectories = self::getDirectories($dir . '/' . $directory); // Use $dir instead of 'Modules/'
            if($directory == 'Gateways'){
                if (in_array('Addon', $subDirectories)) {
                    $addons[] = $dir . '/' . $directory; // Use $dir instead of 'Modules/'
                }
            }
        }

        foreach ($addons as $item) {
            $fullData = include(base_path($item . '/Addon/info.php'));
            return (int)$fullData['is_published'];
        }
        return 0;
    }


    function getDirectories(string $path): array
    {
        $module_dir = base_path('Modules');

        try {
            if (!File::exists($module_dir)) {
                File::makeDirectory($module_dir);
                File::chmod($module_dir, 0777);
            }
        } catch (\Exception $e) {

        }

        $directories = [];
        $items = scandir(base_path($path));
        foreach ($items as $item) {
            if ($item != '.' && $item != '..' && is_dir(base_path($path . '/' . $item))) {
                $directories[] = $item;
            }
        }
        return $directories;
    }

    public function checkSystemAddonsSymbolicLink(): void
    {
        $modulesName = array_keys($this->getModuleNameList());
        if (!File::exists(base_path('public/Modules'))) {
            File::makeDirectory(base_path('public/Modules'),true);
        }

        foreach ($modulesName as $moduleName) {
            if (File::exists(base_path("Modules/{$moduleName}"))) {
                $modulePath = base_path("public/Modules/{$moduleName}");
                if (!File::exists($modulePath) || !File::exists($modulePath.'/assets') || !File::exists($modulePath.'/resources')) {
                    try {
                        File::makeDirectory($modulePath, 0777, true);

                        $targetPath = base_path("public/Modules/{$moduleName}/test.php");
                        file_put_contents($targetPath, "<?php\n\nreturn [\n    'module' => '{$moduleName}',\n];\n");

                        // Create symbolic links
                        if (DOMAIN_POINTED_DIRECTORY == 'public' && function_exists('shell_exec')) {
                            shell_exec("ln -s ../Modules/{$moduleName}/assets ". $modulePath);
                            shell_exec("ln -s ../Modules/{$moduleName}/resources ". $modulePath);
                        } else {
                            shell_exec("ln -s " . base_path("Modules/{$moduleName}/assets") . " " . $modulePath);
                            shell_exec("ln -s " . base_path("Modules/{$moduleName}/resources") . " " . $modulePath);
                        }
                    } catch (\Exception $e) {

                    }
                }
            }
        }
    }

    public function getModuleNameList(): array
    {
        $moduleFileJsonData = [];
        $modulesStatusesFile = base_path('modules_statuses.json');
        if (File::exists($modulesStatusesFile)) {
            $moduleFileJsonData = json_decode(File::get($modulesStatusesFile), true);
        }
        return $moduleFileJsonData;
    }
}
