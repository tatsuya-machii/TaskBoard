# TaskBoard

Claude Code とシステム開発(DDD)の学習用タスクボード。Laravel 13 / PHP 8.3+ / SQLite(開発)。
将来: MySQL + LEMP デプロイ、Vue/React 導入。応答・コメントは日本語。

## コマンド
- 開発サーバー: `composer run dev`(または `php artisan serve` + `npm run dev`)
- テスト: `php artisan test`
- 整形: `vendor/bin/pint`
- フロントビルド: `npm run build`

## DDD 構成と依存ルール(内向きのみ)
```
Http(Presentation) → Application → Domain ← Infrastructure
```
- `app/Domain/Task`: エンティティ・値オブジェクト・Repository IF。**Laravel/Eloquent に依存しない**(`Illuminate\` を use しない)
- `app/Application/Task`: ユースケース(1クラス1操作、`handle()`)と DTO。画面へはエンティティでなく `TaskData` を渡す
- `app/Infrastructure/Persistence`: Eloquent モデル(永続化専用)と Repository 実装。バインドは `DomainServiceProvider`
- `app/Http`: 薄いコントローラ + FormRequest(入力検証)。ドメインの検証ルールと上限値は Domain の定数を参照
- ドメイン例外 `TaskNotFound` / `InvalidTaskId` は `bootstrap/app.php` で 404 にマップ

層チェック: `grep -rn "Illuminate\|Eloquent\|Facades" app/Domain app/Application` が空であること。

## 機能
ダッシュボード(To Do / 進行中 / 完了の3列)、タスクの追加・編集・削除・状態変更。ID は ULID。
