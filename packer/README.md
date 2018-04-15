Tinitter用 AMI作成
===

```
$ cp credential.json.example credential.json
```

としてcredential.jsonにAWSKEYを設定してから

```
$ packer build --force -var-file=credential.json ami.json
```
