import sys
import requests
import json

# Mendapatkan query dari argumen command line
query = sys.argv[1] if len(sys.argv) > 1 else ""

base_url = "https://www.dapurumami.com/search?module=recipe&q=ayam goreng&source=search&mode=ajax"
resep_API = f"/search?module=recipe&q={query}&source=search&mode=ajax"

response = requests.get(base_url + resep_API)
data = response.json().get("data", [])

recipes = []
for recipe in data:
    recipes.append(
        {
            "name": recipe["recipe_name"],
            "image": base_url + "/" + recipe["recipe_image"],
            "description": recipe["recipe_descr"],
        }
    )

print(json.dumps(recipes))
