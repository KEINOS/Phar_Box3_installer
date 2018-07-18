## About the signature file (`.sig` file)

The '<file name>.sig' file is a signature to sign the '<file name>' file.

It is signed with the author's (@KEINOS@Github) private key and it can be verify with he/she's [public key](https://github.com/KEINOS.keys) on GitHub.

```bash
$ # Fetch the first public key from GitHub
$ curl -s https://github.com/KEINOS.keys | head -n 1 > KEINOS.pub
$ 
$ # Convert to 'pkcs8' format
$ ssh-keygen -f KEINOS.pub -e -m pkcs8 > KEINOS.pkcs8.pub
$ 
$ # Verify file
$ openssl dgst -sha1 -verify KEINOS.pkcs8.pub -signature <file name>.sig <file name>
Verified OK
```

By the way, here's my public key in `PKCS8` format.

```text:KEINOS.pkcs8.pub
-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAquOIdnYqU6jpRqIOUYai
1yRNp4H73RdsERxfWl8TxqIfFcXWAI17Rp7g18v8oRhss5EhYwWZrHjf7hVJFQND
2tZhbSVGhbGEKPwDKyE0DWouQ3iiaCIGvfMbmwDKR4H+nPZNA8k6OEdVZi36wwL3
AlPO+J+o9XKCcSKYwlElwNNUkkhqE6sU7mbAd4psa2kBNJwtTbxXQDQIgOB3JoGM
jCn4b1Hr/5XrYsyp1j1VVHRurqFK0kuHGa073zgEtB0FqOnDCgK5+hT554NjTyvT
egTaI6XrH4VXeCYnnVvI1xxvd5I5mkZx5I/5I8NsJelHeH8g2wP/5jxJBwNwIYZL
UvQZDn9g6X2u9aYWxVuGIP4sIervVqXizIJkhgOY1oOqbqjTXTK/z8jUMIt+Eug1
93NHhd1jK/DBxsq0jkL4rv2BmsbgRZxXJ9cN0AUAca+/jE3+2wOKnm+d5dnRasd4
umBI617zyAakJZP4gFctaKZG5n0a1qCY4M/OKeTpuprsTfeMY9m8sFtNzVGmnxSb
0WWEO87yqs06uzUKkAKNRyxsv74WaUYWEanLQac7t/myZcxa6mkgZi47i0wzE7xz
T6zkUKBTys32v0jjd3x0ZjY0WjKUyyQ22jQBGiVyB8J6qXy4Hpc66ykyYB/QbAAc
ti0zvVV+O1IjxmrQOECKP2UCAwEAAQ==
-----END PUBLIC KEY-----
```


