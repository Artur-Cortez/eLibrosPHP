# Copy files with error checking
echo "Updating Apache2 configurations..."
if cp -r ./confs-apache2/* /etc/apache2/; then
    echo "Apache2 configurations updated successfully"
else
    echo "Error updating Apache2 configurations"
    exit 1
fi

echo "Updating frontend files..."
if cp -r ./site-frontend/* /var/www/html/eLibrosPHP/eLibros.com.br/; then
    echo "Frontend files updated successfully"
else
    echo "Error updating frontend files"
    exit 1
fi

echo "Updating backend files..."
if cp -r ./site-backend/* /var/www/html/eLibrosPHP/eLibros.backend.biz/; then
    echo "Backend files updated successfully"
else
    echo "Error updating backend files"
    exit 1
fi

echo "Reloading Apache2..."
if service apache2 reload; then
    echo "Apache2 reloaded successfully"
else
    echo "Error reloading Apache2"
    exit 1
fi

echo "Update completed successfully"