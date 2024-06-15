import os
import shutil
from notion_client import Client
from bs4 import BeautifulSoup
import time
from retrying import retry

# Configuración de las credenciales de Notion
NOTION_API_TOKEN = 'secret_F6HZ24PJwie1nGgnZ46HbZaXgGQZxavYBBA2mWMGsbK'
PARENT_DATABASE_ID = '7ec3db6d4c9d4ba5bd004cab0731cf7e'
CHILD_DATABASE_ID = 'd6195e877a20446c998f6747171ea839'

notion = Client(auth=NOTION_API_TOKEN)

# Ruta a los directorios HTML
base_dir = 'P:/Biblib/BDE/spa/html'
done_dir = os.path.join(base_dir, 'done')

# Crear el directorio 'done' si no existe
if not os.path.exists(done_dir):
    os.makedirs(done_dir)

# Obtener directorios, excluyendo '.', '..' y 'done'
directories = [d for d in os.listdir(base_dir) if os.path.isdir(os.path.join(base_dir, d)) and d not in ['.', '..', 'done']]

for directory in directories:
    dir_path = os.path.join(base_dir, directory)
    done_sub_dir = os.path.join(done_dir, directory)

    # Crear el subdirectorio 'done' si no existe
    if not os.path.exists(done_sub_dir):
        os.makedirs(done_sub_dir)

    if os.path.isdir(dir_path):
        print(f"Processing directory: {directory}")

        # Crear una página para el libro
        page_properties = {
            "parent": {"database_id": PARENT_DATABASE_ID},
            "properties": {
                "Name": {"title": [{"text": {"content": directory}}]}
            }
        }
        main_page = notion.pages.create(**page_properties)

        html_files = os.listdir(dir_path)

        for file in html_files:
            file_path = os.path.join(dir_path, file)
            done_file_path = os.path.join(done_sub_dir, file)

            if file.endswith('.html') and not os.path.exists(done_file_path):
                print(f"Processing file: {file}")

                # Leer contenido HTML
                with open(file_path, 'r', encoding='utf-8') as f:
                    html_content = f.read()

                # Convertir HTML a bloques de Notion
                blocks = convert_html_to_blocks(html_content)

                # Crear una página para el capítulo en la base de datos secundaria
                chapter_page_properties = {
                    "parent": {"database_id": CHILD_DATABASE_ID},
                    "properties": {
                        "Name": {"title": [{"text": {"content": os.path.splitext(file)[0]}}]},
                        "Libros": {"relation": [{"id": main_page['id']}]}
                    }
                }
                created_chapter_page = notion.pages.create(**chapter_page_properties)

                # Añadir bloques a la página del capítulo
                for block in blocks:
                    append_notion_block_with_retry(created_chapter_page['id'], block)

                # Mover el archivo procesado al subdirectorio 'done'
                shutil.move(file_path, done_file_path)

        # Eliminar el directorio procesado si todos los archivos se han movido a 'done'
        if len(os.listdir(dir_path)) == 0:
            os.rmdir(dir_path)

def convert_html_to_blocks(html_content):
    blocks = []
    soup = BeautifulSoup(html_content, 'html.parser')

    supported_tags = ['p', 'h1', 'h2', 'h3', 'ul', 'ol', 'blockquote', 'table', 'img']

    for element in soup.find_all(supported_tags):
        try:
            if element.name == 'img':
                src = element.get('src')
                if src:
                    blocks.append({"type": "image", "image": {"type": "external", "external": {"url": src}}})
            elif element.name == 'table':
                table_blocks = convert_table_to_blocks(element)
                blocks.extend(table_blocks)
            else:
                text_content = clean_html_content(element)
                if element.name == 'p':
                    blocks.append({"type": "paragraph", "paragraph": {"text": [{"type": "text", "text": {"content": text_content}}]}})
                elif element.name == 'h1':
                    blocks.append({"type": "heading_1", "heading_1": {"text": [{"type": "text", "text": {"content": text_content}}]}})
                elif element.name == 'h2':
                    blocks.append({"type": "heading_2", "heading_2": {"text": [{"type": "text", "text": {"content": text_content}}]}})
                elif element.name == 'h3':
                    blocks.append({"type": "heading_3", "heading_3": {"text": [{"type": "text", "text": {"content": text_content}}]}})
                elif element.name == 'ul':
                    for li in element.find_all('li'):
                        li_content = clean_html_content(li)
                        blocks.append({"type": "bulleted_list_item", "bulleted_list_item": {"text": [{"type": "text", "text": {"content": li_content}}]}})
                elif element.name == 'ol':
                    for li in element.find_all('li'):
                        li_content = clean_html_content(li)
                        blocks.append({"type": "numbered_list_item", "numbered_list_item": {"text": [{"type": "text", "text": {"content": li_content}}]}})
                elif element.name == 'blockquote':
                    blocks.append({"type": "quote", "quote": {"text": [{"type": "text", "text": {"content": text_content}}]}})
        except Exception as e:
            print(f"Error processing element {element.name} with content '{text_content}': {e}")

    return blocks

def convert_table_to_blocks(table_element):
    table_blocks = []
    rows = table_element.find_all('tr')
    for row in rows:
        cells = row.find_all(['td', 'th'])
        row_block = {"type": "table_row", "table_row": {"cells": []}}
        for cell in cells:
            cell_content = clean_html_content(cell)
            row_block["table_row"]["cells"].append([{"type": "text", "text": {"content": cell_content}}])
        table_blocks.append(row_block)
    return table_blocks

def clean_html_content(element):
    return ''.join(element.stripped_strings)

@retry(stop_max_attempt_number=5, wait_fixed=100)
def append_notion_block_with_retry(page_id, block):
    notion.blocks.children.append(block_id=page_id, children=[block])
