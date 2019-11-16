#import subprocess

# if the script don't need output.
#subprocess.call("php C:\inetpub\wwwroot\Web\ElectivaWeb-ProyectoRutas\Ruticas\PDF\Generador\generadorNotificacion.php")


# if you want output
#proc = subprocess.Popen("php C:\inetpub\wwwroot\Web\ElectivaWeb-ProyectoRutas\Ruticas\PDF\Generador\generadorNotificacion.php", shell=True, stdout=subprocess.PIPE)
#script_response = proc.stdout.read()

import webbrowser



base_url = "http://localhost/Web/ElectivaWeb-ProyectoRutas/Ruticas/PDF/Generador/generadorNotificacion.php"
webbrowser.open(base_url)
