# Evidence Registry

## Evidencia con checksum

| ID | Fuente | SHA-256 capturado | Fecha | Conocimiento respaldado | Estado |
|---|---|---|---|---|---|
| EVD-001 | `README.md` | `77c48785d8f64e8555c6723c0e34e96ddd68b7d6738b888a7f0de71c36da6638` | 2026-07-01 | Estado declarado, stack, demo, rutas y advisories | `CONFIRMED` |
| EVD-002 | `docs/decisions.md` | `62bafb61e70d05dd3b0b62185fbe833b478f2fae3756f4b95da43f116e728f2a` | 2026-07-01 | DEC-001 a DEC-015 | `CONFIRMED` |
| EVD-003 | `.ai/PROJECT_CONTEXT.md` | `e4861b14ade3c05faa1340e28bb56074cd3e783a79d85e94737ac6d2f10e5170` | 2026-07-01 | Contexto y extensiones Version 2/3 | `CONFIRMED` |
| EVD-004 | `.ai/reports/02-document-conflicts.md` | `2a1032f1c1c7ce5be5370fedb606cee2d713ba158b77d643f882bdc20eb01af6` | 2026-07-01 | Contradicciones DOC-001 a DOC-015 | `CONFIRMED` |
| EVD-005 | `.ai/reports/04-migration-verification-report.md` | `8ed7dc607740b95c638d7062bd8a457ad8f68ca6070b98ab4cfb016537586fa2` | 2026-07-01 | Cierre documental y checksums heredados | `CONFIRMED` |
| EVD-006 | `.ai/reports/05-knowledge-base-core-report.md` | `adfff58d405b11578abbd1a4a82ea5580c95f7e044945392cdfee6f02cb372bf` | 2026-07-01 | Decisiones y estado del BDS Core | `CONFIRMED` |
| EVD-007 | `.ai/core/knowledge-base/KB_CHARTER.md` | `f2021df4b4b8811ffc80c695334f31caa17dab5efd42e5258db1f325760d084d` | 2026-07-01 | Mision y gobierno de Knowledge Base | `CONFIRMED` |

## Evidencia estructural sin checksum registrado

| ID | Fuente | Conocimiento respaldado | Estado | Limite |
|---|---|---|---|---|
| EVD-008 | `routes/web.php` | Existencia de superficies web por rol | `CONFIRMED` | No se realizo analisis funcional en esta captura |
| EVD-009 | `composer.json` y `package.json` | Dependencias declaradas | `CONFIRMED` | No confirma vulnerabilidades actuales ni instalacion efectiva |
| EVD-010 | Roadmap y backlog copiados en `.ai/project/` | Secuencia Sprints 1 a 10 y clasificacion de alcance | `CONFIRMED` | No contiene fechas individuales |
| EVD-011 | Historial disponible de sesion | Prompts, Sprints 11/12 y directiva Knowledge Archivist | `CONFIRMED` | Fuente temporal; preservada en esta KB |
| EVD-012 | `Requerimientos para sistema web.pdf` | Existencia de PDF version 1.4 de 8 paginas | `CONFIRMED` para metadatos | Contenido `PENDING CONFIRMATION` |
| EVD-013 | `docs/MediTurno_Entrevista_Bladimir_Luna.docx` | Existencia de documento Word | `CONFIRMED` para tipo | Contenido `PENDING CONFIRMATION` |

## Matriz de trazabilidad resumida

| Conocimiento | Evidencia principal |
|---|---|
| Decisiones | EVD-002 |
| Estado declarado de funcionalidades | EVD-001, EVD-003, EVD-008 |
| Roadmap y backlog | EVD-010 |
| Contradicciones | EVD-004 |
| Migracion documental | EVD-005 |
| Knowledge Base Core | EVD-006, EVD-007 |
| Prompts importantes | EVD-011 |
| Fuentes externas pendientes | EVD-012, EVD-013 |

## Regla de integridad

Los checksums identifican la version capturada el 2026-07-01. Si una fuente cambia,
su evidencia debe registrarse como una nueva version; no se debe sobrescribir
silenciosamente este registro.
