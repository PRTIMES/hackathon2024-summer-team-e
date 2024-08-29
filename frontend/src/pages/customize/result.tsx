import { Box, Container, Typography, Button } from '@mui/material'
import type { NextPage } from 'next'
import Link from 'next/link'
import { useRouter } from 'next/router'
import { useState, useEffect } from 'react'
import ArticleCard from '@/components/ArticleCard'
import Loading from '@/components/Loading'
import { ky } from '@/libs/ky'

type ArticleProps = {
  title: string
  summary: string
  company_name: string
  url: string
}

const Index: NextPage = () => {
  const [articles, setArticles] = useState<ArticleProps[]>([])
  const [loading, setLoading] = useState<boolean>(true)

  const router = useRouter()

  useEffect(() => {
    setLoading(true)
  }, [])

  useEffect(() => {
    if (!router.isReady) return

    const raw_company_id = router.query['company_ids']
    if (!raw_company_id) {
      router.push('/customize/industry').then()
      return
    }

    const company_ids = Array.isArray(raw_company_id)
      ? raw_company_id
      : [raw_company_id]

    const searchParams = new URLSearchParams()
    company_ids.forEach((company_id) => {
      searchParams.append('company_ids[]', company_id)
    })

    ky.get('./api/press-release/company', {
      searchParams,
    })
      .then((v) => {
        return v.json<
          {
            title: string
            summary: string
            company_name: string
            url: string
          }[]
        >()
      })
      .then((value) => {
        setLoading(false)
        setArticles(value)
      })
  }, [router, router.query])

  if (loading) return <Loading />

  return (
    <Box sx={{ backgroundColor: 'white', minHeight: '100vh', p: 4 }}>
      <Typography
        variant="h3"
        component="h1"
        sx={{ textAlign: 'center', mb: 2, color: 'text.primary' }}
      >
        選択した企業のピックアッププレスリリース
      </Typography>
      <Typography
        variant="body1"
        component="p"
        sx={{ textAlign: 'center', mb: 4, color: 'text.primary' }}
      >
        あなたが気になる記事を選ぼう
      </Typography>
      <Container maxWidth="md">
        {articles.map((article, id) => (
          <Box key={id} sx={{ mb: 4, bgcolor: 'white' }}>
            <ArticleCard {...article} />
          </Box>
        ))}
        <Box sx={{ textAlign: 'center', mt: 4 }}>
          <Button
            component={Link}
            href="/customize/industry"
            variant="contained"
          >
            業種・会社から探し直す
          </Button>
          <Button
            component={Link}
            href="/home"
            variant="contained"
            sx={{ ml: 2 }}
          >
            カスタマイズされたプレスリリースを見る
          </Button>
        </Box>
      </Container>
    </Box>
  )
}

export default Index
