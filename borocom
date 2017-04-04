include common/upstream;

server
{
    # Порты
	listen	80;
	listen	443	ssl;	# использовать шифрование для этого порта
	root			/var/www/currentProjects/WeatherForecast;
	index			index.php index.html index.htm;
	server_name		localhost;
	
    charset utf-8; 
    location / {
        try_files $uri $uri/ =404;
        if (!-e $request_filename){ 
        rewrite ^(.*)$ /index.php; } 
    }
    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass unix:/var/run/php/php7.0-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param   SCRIPT_FILENAME   $document_root$fastcgi_script_name;
    }
}
