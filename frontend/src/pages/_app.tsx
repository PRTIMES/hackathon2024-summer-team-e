import '@/styles/globals.css'
import type { AppProps } from 'next/app'
import { useEffect } from 'react'
import Header from '@/components/Header'
import { ky } from '@/libs/ky'

export default function App({ Component, pageProps }: AppProps) {
  useEffect(() => {
    // Get XSRF-TOKEN
    ky.get('./sanctum/csrf-cookie').then()
  }, [])

  return (
    <>
      <Header />
      <Component {...pageProps} />;
    </>
  )
}
