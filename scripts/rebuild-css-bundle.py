#!/usr/bin/env python3
"""Rebuild assets/css/bundle.css from style.css + @import targets.

Jangan edit bundle.css manual. Ubah file sumber, lalu jalankan skrip ini.
"""
from __future__ import annotations

import os
import re
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
CSS_DIR = ROOT / "assets" / "css"
STYLE = CSS_DIR / "style.css"
OUT = CSS_DIR / "bundle.css"


def main() -> None:
	style = STYLE.read_text(encoding="utf-8", errors="replace")
	imports = re.findall(r"@import\s+url\((['\"]?)([^)'\"]+)\1\);", style)

	google: list[str] = []
	local: list[str] = []
	other: list[str] = []
	for _, url in imports:
		u = url.strip()
		if u.startswith("http://") or u.startswith("https://"):
			google.append(u)
		elif u.startswith("../"):
			other.append(u)
		else:
			local.append(u)

	parts: list[str] = []
	parts.append(
		"/* AUTO-GENERATED: assets/css/bundle.css\n"
		" * Jangan edit file ini. Edit style.css / file sumber, lalu jalankan:\n"
		" *   python3 scripts/rebuild-css-bundle.py\n"
		" */\n"
	)
	for g in google:
		parts.append(f"@import url('{g}');\n")

	seen: set[str] = set()

	def append_file(label: str, path: Path, rewrite_urls: bool = False) -> None:
		key = str(path.resolve())
		if key in seen:
			return
		seen.add(key)
		if not path.exists():
			parts.append(f"/* MISSING {label} */\n")
			print("MISSING", label)
			return
		parts.append(f"\n/* ===== {label} ===== */\n")
		text = path.read_text(encoding="utf-8", errors="replace")
		if rewrite_urls:
			import_dir = path.parent

			def fix_url(m: re.Match[str]) -> str:
				raw = m.group(1).strip("'\"")
				if (
					raw.startswith("data:")
					or raw.startswith("http://")
					or raw.startswith("https://")
					or raw.startswith("/")
				):
					return m.group(0)
				abs_path = (import_dir / raw).resolve()
				try:
					rel_to_css = Path(os.path.relpath(abs_path, CSS_DIR.resolve())).as_posix()
				except Exception:
					return m.group(0)
				return f"url({rel_to_css})"

			text = re.sub(r"url\(([^)]+)\)", fix_url, text)
		parts.append(text)
		parts.append("\n")

	for rel in local:
		append_file(rel, CSS_DIR / rel)

	for rel in other:
		append_file(rel, (CSS_DIR / rel).resolve(), rewrite_urls=True)

	body = re.sub(r"@import\s+url\((['\"]?)([^)'\"]+)\1\);\s*", "", style)
	parts.append("\n/* ===== style.css (tanpa @import) ===== */\n")
	parts.append(body)

	OUT.write_text("".join(parts), encoding="utf-8")
	print(f"OK wrote {OUT} ({OUT.stat().st_size} bytes)")


if __name__ == "__main__":
	main()
