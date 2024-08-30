import Link from 'next/link'
import React from 'react'

export default function Top() {
  return (
    <div className="relative isolate overflow-hidden bg-gray-600 min-h-screen py-24 sm:py-32 flex flex-col justify-center items-center">
      <div className="px-4 sm:px-6 lg:px-8 text-center">
        <h2 className="text-4xl font-bold tracking-tight text-white sm:text-6xl">
          サチポ
        </h2>
        <p className="mt-6 text-lg leading-8 text-gray-300">
          あなたに合った記事を見つけられる
        </p>
        <p className="mt-6 text-lg leading-8 text-gray-300">
          あなたの興味や関心を入力してください。新しい発見と情報探索の旅を、ここから一緒に始めましょう!
        </p>
        <Link href="/signup">
          <button className="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            新規登録
          </button>
        </Link>
        <Link href="/signin">
          <button className="mt-4 px-4 py-2 ml-4 bg-blue-500 text-white rounded hover:bg-blue-600">
            ログイン
          </button>
        </Link>
      </div>
    </div>
  )
}
