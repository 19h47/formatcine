# Format'ciné

## Docker

```bash
docker-compose down --volumes
```

```bash
docker-compose up -d
```

## Make an url point to localhost

```bash
sudo nano /etc/hosts
```

```
127.0.0.1 formatcine.test www.formatcine.test
```

Then type `ctrl + x`, and `y` to save and exit nano. Now, the custom url points to `localhost`.
