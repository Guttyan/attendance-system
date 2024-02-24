FROM ubuntu:latest

# 必要なパッケージのインストール
RUN apt-get update && apt-get -y install cron

# コンテナ起動時にcronを開始するスクリプトの追加
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
CMD ["/entrypoint.sh"]