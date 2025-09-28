import subprocess

# Import de database.sql
subprocess.run('mysql -u firemen_user -p1234 < database.sql', shell=True)

# Import de data.sql
subprocess.run('mysql -u firemen_user -p1234 < data.sql', shell=True)
