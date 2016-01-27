# -*- mode: ruby -*-
# vi: set ft=ruby :
# check if hostmanager plugin can be used


$script = <<SCRIPT
sed -i 's:ServerName scotchbox.local:ServerName myportfolio.com:g' /etc/apache2/sites-available/scotchbox.local.conf
sed -i 's:ServerAlias www.scotchbox.local:ServerAlias dev.myportfolio.com:g' /etc/apache2/sites-available/scotchbox.local.conf
sed -i 's:DocumentRoot /var/www/public:DocumentRoot /var/www/web:g' /etc/apache2/sites-available/scotchbox.local.conf
service apache2 reload
SCRIPT

Vagrant.require_version ">= 1.7.4"

# Make sure all dependencies are installed
[
    { :name => "vagrant-hostmanager", :version => ">= 1.6.0" }
].each do |plugin|
    Vagrant::Plugin::Manager.instance.installed_specs.any? do |s|
        req = Gem::Requirement.new([plugin[:version]])
        if not Vagrant.has_plugin?(plugin[:name], plugin[:version])
            raise "#{plugin[:name]} #{plugin[:version]} is required. Please run `vagrant plugin install #{plugin[:name]}`"
        end
    end
end

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

    if Vagrant.has_plugin?("vagrant-hostmanager")
        config.hostmanager.enabled = true
        config.hostmanager.manage_host = true
        config.hostmanager.ignore_private_ip = false
        config.hostmanager.include_offline = true
    end

    config.vm.box = "scotch/box"

    config.vm.provider "virtualbox" do |v|
        # show a display for easy debugging
        v.gui = false

        # RAM size
        v.memory = 2048

        # Allow symlinks on the shared folder
        v.customize ["setextradata", :id, "VBoxInternal2/SharedFoldersEnableSymlinksCreate/v-root", "1"]
    end

    # allow external connections to the machine
    #config.vm.forward_port 80, 8080

    # Shared folder over NFS
    if Vagrant::Util::Platform.windows?
        config.vm.synced_folder ".", "/var/www", type: "smb"
    else
        config.vm.synced_folder ".", "/var/www", type: "nfs"
    end

    config.vm.network "private_network", ip: "192.168.33.33"
    config.vm.hostname = "dev.myportfolio.com"

    # Shell provisioning
    config.vm.provision :shell, :inline => $script
end
