from django.http import HttpResponse
from django.template import Context, Template, loader
from django.shortcuts import render
from django.core.files import File
from pathlib import Path
import mysql.connector
from mysql.connector import Error
import codecs
import webbrowser


def initial_function(request):  # Primera vista
    # print(str(Path().absolute()))
    f = open('Consulta.txt', 'w')
    myfile = File(f)
    myfile.write(consulta())
    myfile.closed
    ejecutarArchivo()
    return HttpResponse("Reporte Generado Satisfactoriamente. Puede cerrar esta ventana.")


def consulta():
    respuesta = " "
    try:
        connection = mysql.connector.connect(host='104.196.172.139',
                                             database='labWeb',
                                             user='root',
                                             password='electiva2019')
        miCursor = connection.cursor()

        miCursor.callproc("getNotificaciones")
        respuesta = "Notificaciones <br><br>"
        header = "<table>"
        header = header + "<tr>"
        header = header + "<th>Descripción</th>"
        header = header + "<th>Latitud</th>"
        header = header + "<th>Longitud</th>"
        header = header + "<th>Fecha</th>"
        header = header + "</tr>"
        respuesta += header
        for result in miCursor.stored_results():
            x = result.fetchall()
            for datos in x:
                fila = "<tr>"
                fila = fila + "<td>" + str(datos[1]) + "</td>"
                fila = fila + "<td>" + str(datos[2]) + "</td>"
                fila = fila + "<td>" + str(datos[3]) + "</td>"
                fila = fila + "<td>" + str(datos[4]) + "</td>"
                fila = fila + "</tr>"
                respuesta += fila + "</table>"
    except mysql.connector.Error as error:
        respuesta += "Failed to execute stored procedure: {}" + str(error)
    finally:
        if (connection.is_connected()):
            miCursor.close()
            connection.close()
            print("Respuesta: " + respuesta)
            return respuesta


def ejecutarArchivo():
    base_url = "http://localhost/ElectivaWeb-ProyectoRutas/Ruticas/PDF/Generador/generadorNotificacion.php"
    webbrowser.open(base_url)
