VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  config.vm.box = "centos65-x86_64-20131205"
  config.vm.box_url = "https://github.com/2creatives/vagrant-centos/releases/download/v6.5.1/centos65-x86_64-20131205.box"

  # Set the IP address of unused if it would conflict with the IP you are using already
  config.vm.network :private_network, ip: "192.168.33.11"

  # Set up for Network delay
  config.vm.provider :virtualbox do |vb|
    vb.customize ["modifyvm", :id, "--natdnsproxy1", "off"]
    vb.customize ["modifyvm", :id, "--natdnshostresolver1", "off"]
  end

  # Set up Synced folder
  # config.vm.synced_folder "./", "/home/vagrant"

  # Install php
  config.vm.provision :shell, :inline => <<-EOS
    rpm -Uhv http://rpms.famillecollet.com/enterprise/5/remi/x86_64/remi-release-5.10-1.el5.remi.noarch.rpm
    yum -y update remi-release
    yum -y --enablerepo=remi install php php-mcrypt php-xml php-pdo
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/
    ln -s /usr/local/bin/composer.phar /usr/local/bin/composer
  EOS

end