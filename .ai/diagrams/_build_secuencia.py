import pathlib, base64

base = pathlib.Path("/home/willian/workspace/incos/tercerAnio/web3/HMIGU1/.ai/diagrams")

mods = [
    ("02-authentication-dashboard", "Autenticación y Dashboard"),
    ("03-users", "Gestión de Usuarios"),
    ("04-hospital-services", "Gestión de Servicios Hospitalarios"),
    ("05-staff", "Gestión de Personal de Salud"),
    ("06-service-managers", "Asociación de Jefes de Servicio"),
    ("07-shift-templates", "Gestión de Plantillas de Turno"),
    ("08-shift-assignments", "Asignación de Turnos (Validación de Conflictos)"),
    ("09-calendar", "Calendario Mensual (FullCalendar)"),
    ("10-reports", "Reportes de Turnos"),
    ("11-shift-change-requests", "Solicitudes de Cambio de Turno"),
    ("12-notifications", "Notificaciones Internas"),
    ("13-audit", "Bitácora de Auditoría"),
]

html_parts = []
html_parts.append("""<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
  body { font-family: 'DejaVu Sans', Arial, sans-serif; margin: 40px; color: #1a1a1a; }
  h1 { font-size: 22px; text-align: center; margin-bottom: 4px; }
  .encabezado { text-align: center; font-size: 13px; margin-bottom: 6px; }
  .sub { text-align: center; font-size: 12px; color: #333; margin-bottom: 30px; }
  .diagrama { margin: 40px 0; page-break-inside: avoid; }
  .diagrama h2 { font-size: 15px; border-bottom: 1px solid #999; padding-bottom: 4px; color: #0d47a1; }
  .diagrama .figura { text-align: center; margin: 12px 0; }
  .diagrama .figura img { max-width: 100%; height: auto; }
  .diagrama .fuente { font-size: 10px; color: #555; text-align: center; }
  .portada { text-align: center; margin-top: 120px; }
  .portada .sistema { font-size: 26px; font-weight: bold; color: #0d47a1; margin-top: 20px; }
  .portada .doc { font-size: 18px; margin-top: 10px; }
  .portada .meta { font-size: 14px; margin-top: 40px; line-height: 1.8; }
</style>
</head>
<body>
<div class="portada">
  <div class="sistema">MediTurno</div>
  <div class="doc">Diagramas de Secuencia</div>
  <div class="sub">Sistema Web de Gestión de Turnos del Personal de Salud</div>
  <div class="meta">
    <b>Integrantes:</b> Bladimir Luna Corrales<br/>
    <b>Grupo:</b> Individual<br/><br/>
    <b>Institución:</b> ITNC "Federico Álvarez Plata" (Nocturno)<br/>
    <b>Asignatura:</b> Proyecto de Grado<br/>
    <b>Fuente:</b> Elaboración propia · Software implementado (Laravel 10 + MySQL)
  </div>
</div>
""")

for folder, titulo in mods:
    # Usar render PlantUML (preferido por el usuario)
    png = base / folder / "03-sequence-plantuml.png"
    if not png.exists():
        png = base / folder / "03-sequence-mermaid.png"
    b64 = base64.b64encode(png.read_bytes()).decode()
    html_parts.append(f"""
<div class="diagrama">
  <h2>{titulo}</h2>
  <div class="figura">
    <img src="data:image/png;base64,{b64}" alt="{titulo}"/>
  </div>
  <div class="fuente">Diagrama de Secuencia — {titulo} · Elaboración propia · Bladimir Luna Corrales</div>
</div>
""")

html_parts.append("</body></html>")

outdir = base / "entrega-secuencia"
outdir.mkdir(parents=True, exist_ok=True)
out = outdir / "diagramas-secuencia.html"
out.write_text("".join(html_parts), encoding="utf-8")
print("HTML:", out, "bytes:", out.stat().st_size)
