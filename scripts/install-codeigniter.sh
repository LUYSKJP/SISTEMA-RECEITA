#!/usr/bin/env bash
set -euo pipefail

CI_VERSION="3.1.13"
CI_URL="https://github.com/bcit-ci/CodeIgniter/archive/${CI_VERSION}.zip"

if [ -d "system" ]; then
  echo "system/ already exists. Remove it if you want to re-install CodeIgniter." >&2
  exit 1
fi

tmp_dir=$(mktemp -d)
trap 'rm -rf "${tmp_dir}"' EXIT

echo "Downloading CodeIgniter ${CI_VERSION}..."
curl -L "${CI_URL}" -o "${tmp_dir}/ci.zip"

unzip -q "${tmp_dir}/ci.zip" -d "${tmp_dir}"

cp -R "${tmp_dir}/CodeIgniter-${CI_VERSION}/system" ./system

echo "CodeIgniter system/ directory installed."
